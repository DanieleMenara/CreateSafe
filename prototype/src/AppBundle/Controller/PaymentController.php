<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Component\HttpFoundation\JsonResponse;

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
            ->add('pay', SubmitType::class, array('label' => 'Pay'))
            ->setAction($this->generateUrl('paymentProcessing'))
            ->getForm();
        return $form;
    }

    public function prepareAction()
    {
        $gatewayName = 'paypal_express_checkout';

        $storage = $this->get('payum')->getStorage('AppBundle\Entity\Payment');

        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('GBP');
        $payment->setTotalAmount(500);
        $payment->setDescription('CreateSafe upload');
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
     * @Route("/payment/done", name="done")
     */
    public function doneAction(Request $request)
    {
        $token = $this->get('payum.security.http_request_verifier')->verify($request);

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum.security.http_request_verifier')->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$payment = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));
    }
}