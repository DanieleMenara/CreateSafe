<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class ProtectedFile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $userId;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="protected_file", fileNameProperty="imageName")
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $originalName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $extension;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="date")
     *
     * @var \DateTime
     */
    private $dateProtected;

    /**
     * @param int $newID
     *
     * @return ProtectedFile
     */
    public function setUserID($newID)
    {
        $this->userId = $newID;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserID()
    {
        return $this->userId;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $newFile
     *
     * @return ProtectedFile
     */
    public function setFile(File $newFile = null)
    {
        $this->file = $newFile;

        if ($newFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $newName
     *
     * @return ProtectedFile
     */
    public function setFileName($newName)
    {
        $this->fileName = $newName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $newName
     *
     * @return ProtectedFile
     */
    public function setOriginalName($newName)
    {
        $this->originalName = $newName;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $newExtension
     *
     * @return ProtectedFile
     */
    public function setExtension($newExtension)
    {
        $this->extension = $newExtension;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $newDate
     *
     * @return ProtectedFile
     */
    public function setDateProtected($newDate)
    {
        $this->dateProtected = $newDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateProtected()
    {
        return $this->dateProtected;
    }
}