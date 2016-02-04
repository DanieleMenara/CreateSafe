<?php

namespace AppBundle\Tests;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\BrowserKit\Cookie;
use FOS\UserBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class FakeLogin {
    private static function getUserManager($container) {
        return $container->get('fos_user.user_manager');

    }

    private static function getSecurityManager($container) {
        return $container->get('fos_user.security.login_manager');

    }

    //create test user
    public static function getUser($container, $role = null) {
        $userManager = FakeLogin::getUserManager($container);
        $userEmail = 'user@test.test';
        $user = $userManager->findUserByUsernameOrEmail($userEmail);

        if (!isset($user)) {
            $user = $userManager->createUser();

            $user->setEnabled(true);
            $user->setEmail($userEmail);
            $user->setPlainPassword('user');
            $user->setFirstName('First');
            $user->setLastName('Last');
            $userManager->updatePassword($user);
            //if needed admin use ROLE_ADMIN
            if (isset($role)) {
                $user->addRole($role);
            }
            $userManager->updateUser($user, true);;
        }
        return $user;
    }

    public static function logIn($client, $container, $user) {
        $session = $container->get('session');
        if(!$session->isStarted()) {
            $session->start();
        }
        $firewallName = $container->getParameter('fos_user.firewall_name');
        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
        FakeLogin::getSecurityManager($container)->loginUser($firewallName, $user);
        $session->set('_security_'.$firewallName, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    public static function removeUser(User $user, $container) {
        FakeLogin::getUserManager($container)->deleteUser($user);
    }
}