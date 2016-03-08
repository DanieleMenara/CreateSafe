<?php

namespace AppBundle\Services;

use \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class HashingRegistrationNumber implements RegistrationNumberCreator
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    private $hashedUsername;


    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage    $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->hashedUsername = password_hash($this->tokenStorage->getToken()->getUser()->getUsername(), PASSWORD_DEFAULT);
        if(strlen($this->hashedUsername)>12) {
            $this->hashedUsername = substr($this->hashedUsername, -12);
        }
    }

    /**
     * Create a unique string generated using uniqid prefixed by the hashed username. The tot length of
     *  the name is going to be 34 chars long (12 from hashed username and 22 from uniqid).
     *
     * @return string
     */
    public function getUniqueRegistrationNumber()
    {
        $newName = md5(uniqid(null, true));
        $newName = $this->hashedUsername . substr($newName, 0, 22);
        $newName = preg_replace('((^\.)|\/|(\.$)|(\$2y\$10\$)|\.)', '', $newName); //get rid of chars that can conflict with path specifications (e.g. forward slash)
        return $newName;
    }
}