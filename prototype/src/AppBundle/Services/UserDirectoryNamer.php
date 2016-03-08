<?php

namespace AppBundle\Services;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UserDirectoryNamer implements DirectoryNamerInterface, NamerInterface
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

    /**
     * Name a given file and return the name
     *
     * @param  FileInterface $file
     * @return string
     */
    public function name(FileInterface $file)
    {
        return sprintf('%s/%s', $this->getUser()->getId(), $file->getBasename());
    }
}