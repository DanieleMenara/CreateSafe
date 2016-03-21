<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProfileController extends BaseController
{
    public function showAction()
    {
        $request = $this->get('Request');
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $orderBy = "dateProtected:ASC"; // set default order

        if ($request->isXMLHttpRequest() && null !== $request->request->get('orderBy')) {
            $orderBy = $request->request->get('orderBy');
        }

        $files = $this->getDoctrine()
            ->getRepository('AppBundle:ProtectedFile')
            ->findBy(
                array("userId" => $user->getId()),
                array(explode(':', $orderBy)[0] => explode(':', $orderBy)[1])
            );

        if ($request->isXMLHttpRequest()) {
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            return new Response($serializer->serialize($files, 'json')); // If the request was sent by Ajax, just JSON encode the data and return it
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'protectedFiles' => $files
        ));
    }

    public function viewProtectedWorkAction($id) {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $file = $this->getDoctrine()
            ->getRepository('AppBundle:ProtectedFile')
            ->findOneBy(
                array("userId" => $user->getId(), "registrationNumber" => $id)
            );

        //needed for the cease&desist functionality
        $files = $this->getDoctrine()
            ->getRepository('AppBundle:ProtectedFile')
            ->findBy(
                array("userId" => $user->getId())
            );

        if(!isset($file)) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('profile/viewProtectedWork.html.twig', array(
            'user' => $user,
            'file' => $file,
            'protectedFiles' => $files
        ));
    }

    public function ceaseAndDesistAction(Request $request) {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        try {
            $name = $request->request->get('name');
            $work = $request->request->get('work');

            //needed for the cease&desist functionality
            $files = $this->getDoctrine()
                ->getRepository('AppBundle:ProtectedFile')
                ->findBy(
                    array("userId" => $user->getId())
                );
            return $this->render('profile/ceaseAndDesist.html.twig', array(
                'user' => $user,
                'name' => $name,
                'work' => $work,
                'protectedFiles' => $files
            ));
        } catch (\Exception $e) {
            //return $this->redirectToRoute('fos_user_profile_show');

            //use for debugging purposes
            return new Response($e->getMessage());
        }
    }

    public function deleteWorkAction($id) {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();

        $file = $this->getDoctrine()
            ->getRepository('AppBundle:ProtectedFile')
            ->findOneBy(
                array("userId" => $user->getId(), "registrationNumber" => $id)
            );

        if(!isset($file)) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        //If file is a PDF remove the png preview created for visualisation purposes as well.
        if($file->getExtension() == 'pdf') {
            $dir = new Filesystem();
            $dir->remove($file->getPath().'/'.$file->getRegistrationNumber().'.png');
        }

        $em->remove($file);
        $em->flush();

        return $this->redirectToRoute('fos_user_profile_show');
    }

    public function inviteFriendAction(Request $request) {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $response = array('success' => 'false');
        if ($request->isXMLHttpRequest() && null !== $request->request->get('email')) {
            $emailTo = $request->request->get('email');
            $emailConstraint = new Assert\Email();
            $emailConstraint->message = 'Invalid email address';

            // use the validator to validate the value
            $errorList = $this->get('validator')->validate(
                $emailTo,
                $emailConstraint
            );
            if(0 === count($errorList)) {
                try {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Join CreateSafe')
                        ->setFrom(array('createsafedonotreply@gmail.com' => 'CreateSafe'))
                        ->setTo($emailTo)
                        ->setBody(
                            $this->renderView(
                                'views/email/inviteFriends.html.twig',
                                array('confirmationUrl' => '/', 'user' => $this->getUser())
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);
                    $response['success'] = 'true';
                } catch (\Exception $e) {
                    $response['success'] = 'false';

                    //use for debugging purposes
                    //$response['error'] = $e->getMessage();
                }
            } else {
                $response['invalidEmail'] = true;
            }
        }

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($response, 'json'));
    }
}