<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
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

        if(!isset($file)) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('profile/viewProtectedWork.html.twig', array(
            'user' => $user,
            'file' => $file
        ));
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

        $em->remove($file);
        $em->flush();

        return $this->redirectToRoute('fos_user_profile_show');
    }
}