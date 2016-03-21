<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProtectedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Oneup\UploaderBundle\Uploader\File\FilesystemFile;
use WaterMark;

class PaymentController extends Controller
{
    /**
     * @Route("/payment", name="payment")
     */
    public function payment(Request $request)
    {
        $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');

        $session = $request->getSession();

        //restore correct sessionID if necessary
        if($session->has('originalSessionID')) {
            $sessionID = $session->get('originalSessionID');
            $session->save();
            $session->setId($sessionID);
        }

        // get files
        $files = $manager->getFiles();

        //if there aren't files redirect home
        $num = $files->count();
        if($num == 0) {
            return $this->redirectToRoute('homepage');
        }

        foreach($files as $file) {
            $name = $file->getFilename();
            $name = pathinfo($name, PATHINFO_FILENAME); //remove extension
            $names[$name] = $file->getExtension();
        }

        $form = $this->buildForm();

        return $this->render(
            'payment/payment.html.twig',
            array(
                'files' => $names,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/paymentProcessing", name="paymentProcessing")
     */
    public function paymentAction(Request $request) {
        $form = $this->buildForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $method = $form->getData()['paymentMethod'];
            switch($method) {
                case 'paypal':
                    return $this->prepareAction();
            }
        }
        return $this->redirectToRoute('payment');

    }

    private function buildForm() {
        $form = $this->createFormBuilder(null)
            ->add('paymentMethod', ChoiceType::class, array(
                'choices'  => array(
                    '0' => 'paypal',
                    '1' => 'other' //change when implementing other payment methods + change input value in HTML file
                ),
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false
            ))
            ->add('pay', SubmitType::class, array('label' => 'Complete purchase'))
            ->setAction($this->generateUrl('paymentProcessing'))
            ->getForm();
        return $form;
    }

    public function prepareAction()
    {
        $gatewayName = 'paypal_express_checkout';

        $storage = $this->get('payum')->getStorage('AppBundle\Entity\Payment');

        $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
        $files = $manager->getFiles();
        $details = array();
        foreach($files as $file) {
            $detail = array();
            $detail['name'] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $detail['description'] = $file->getExtension();
            $detail['price'] = 5.00;
            $detail['currency'] = 'GBP';
            $details[] = $detail;
        }

        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('GBP');
        $payment->setTotalAmount(500*$files->count());
        $payment->setDescription('CreateSafe upload');
        $payment->setDetails($details);
        $payment->setClientId('anId');
        $payment->setClientEmail('foo@example.com');

        $storage->update($payment);

        $captureToken = $this->get('payum.security.token_factory')->createCaptureToken(
            $gatewayName,
            $payment,
            'done' // the route to redirect after capture
        );

        return $this->redirect($captureToken->getTargetUrl());
    }

    /**
     * Rename each file before upload to a unique name (since all the files will be located in the same folder).
     * Each file is renamed using the RegistrationNumberCreator service (current implementation: HashingRegistrationNumber).
     *
     * @return array
     */
    private function renameFiles() {
        $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
        $files = $manager->getFiles();
        $names = array();
        $namer = $this->get('registration.number.namer');
        foreach($files as $file) {
            $newName = $namer->getUniqueRegistrationNumber();
            $name = $file->getFilename();
            $names[$newName.'.'.$file->getExtension()] = pathinfo($name, PATHINFO_FILENAME);
            $newPath = $file->getPath().'/'.$this->getUser()->getId().'/'.$newName.'.'.$file->getExtension();
            if(!file_exists($file->getPath().'/'.$this->getUser()->getId())) {
                mkdir($file->getPath() . '/' . $this->getUser()->getId());
            }
            rename($file->getPath().'/'.$name, $newPath);
        }
        return $names;
    }

    private function stampFiles($files)
    {
        $marker = $this->get('watermark.marker');
        foreach($files as $file) {
            $marker->marker($file->getPathname());
        }
    }

    /**
     * @Route("/payment/done", name="done")
     */
    public function doneAction(Request $request)
    {
        $token = $this->get('payum.security.http_request_verifier')->verify($request);

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$payment = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        //invalidate the token. The url cannot be requested any more.
        $this->get('payum.security.http_request_verifier')->invalidate($token);

        //if payment is successful
        if($status->isCaptured()) {
            $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();
            }
            $originalNames = $this->renameFiles();
            $files = $manager->uploadFiles();
            $this->stampFiles($files);
            $protectedFiles = array();
            foreach($files as $file) {
                $protected = new ProtectedFile();
                $protected->setUserID($this->getUser()->getId());
                $protected->setFileName($file->getFilename());
                $protected->setOriginalName($originalNames[$file->getFilename()]);
                $protected->setExtension($file->getExtension());
                $protected->setDateProtected(new \DateTime('now'));
                $protected->setRegistrationNumber(pathinfo($file->getFilename(), PATHINFO_FILENAME));
                $protected->setFile($file);
                $em = $this->getDoctrine()->getManager();
                $em->persist($protected);
                $em->flush();
                $protectedFiles[] = $protected;
            }

            //send certification email
            try {
                $user = $this->getUser();
                $emailTo = $user->getEmail();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Congratulations!')
                    ->setFrom(array('createsafedonotreply@gmail.com' => 'CreateSafe'))
                    ->setTo($emailTo)
                    ->setBody(
                        $this->renderView(
                            'email/certification.html.twig',
                            array('files' => $protectedFiles)
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);
            } catch (\Exception $e) {
                //TODO: log exception;
                //use for debugging purposes
                return new Response($e->getMessage());
            }
            $response = $this->render('payment/success.html.twig');
        } else {
            $response =  $this->render('payment/unsuccess.html.twig');
        }

        //after 3 seconds redirect to user's profile
        $response->headers->set('Refresh', '3; '.$this->get('router')->generate('fos_user_profile_show'));

        return $response;

        //to be used for debugging purposes
        /*return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));*/
    }
}