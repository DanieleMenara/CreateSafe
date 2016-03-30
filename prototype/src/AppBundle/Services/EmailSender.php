<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class EmailSender
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function getUser()
    {
        return $this->container->get('security.context')->getToken()->getUser();
    }

    public function sendCertificationEmail($protectedFiles) {
        try {
            $user = $this->getUser();
            $emailTo = $user->getEmail();
            $message = \Swift_Message::newInstance()
                ->setSubject('Congratulations!')
                ->setFrom(array('createsafedonotreply@gmail.com' => 'CreateSafe'))
                ->setTo($emailTo)
                ->setBody(
                    $this->container->get('templating')->render(
                        'email/certification.html.twig',
                        array('files' => $protectedFiles)
                    ),
                    'text/html'
                );
            $this->container->get('mailer')->send($message);
        } catch (\Exception $e) {
            //TODO: log exception;
            //use for debugging purposes
            //return new Response($e->getMessage());
        }
    }
}