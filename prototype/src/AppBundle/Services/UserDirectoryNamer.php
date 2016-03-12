<?php

namespace AppBundle\Services;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserDirectoryNamer
 * Directory namer for vich uploader. The upload destination folder is the userID (hence,
 * unique for each user).
 * service name: directory_namer.user
 * argument: "@security.token_storage"
 *
 * @package AppBundle\Services
 */
class UserDirectoryNamer implements DirectoryNamerInterface
{

    /**
     * @var TokenStorage
     */
    private $tokenStorage;


    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage    $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    private function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param object $object The object the upload is attached to.
     * @param Propertymapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The directory name.
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        return $this->getUser()->getId();
    }
}