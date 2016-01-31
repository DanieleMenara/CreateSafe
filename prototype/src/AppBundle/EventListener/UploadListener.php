<?php
namespace AppBundle\EventListener;

use Oneup\UploaderBundle\Event\PostUploadEvent;
use Symfony\Component\Finder\Finder;


class UploadListener
{
    public function __construct($doctrine = null)
    {
        $this->doctrine = $doctrine;
    }

    public function onUpload(PostUploadEvent $event)
    {
        //save original sessionID to be recovered later if user login (sessionID changes)
        $session = $event->getRequest()->getSession();
        $session->set('originalSessionID', $session->getId());

        //rename file to original name
        $request = $event->getRequest();
        $file = $request->files->get('file');
        $uploadedFile = $event->getFile();
        $originalName = $file->getClientOriginalName();
        $originalName = $this->nextAvailableName($uploadedFile, $originalName, $originalName, $file->getClientOriginalExtension(), 1);
        $uploadedFile->move($uploadedFile->getPath(), $originalName);
    }

    //rename file if there exists already a file with same name.
    private function nextAvailableName($uploadedFile, $originalName, $newName, $extension, $i) {
        $finder = new Finder();
        $files = $finder->files()->in($uploadedFile->getPath());
        foreach($files as $file) {
            if($file->getBasename() == $newName) {
                return $this->nextAvailableName($uploadedFile, $originalName, $this->removeExtension($originalName).$i.'.'.$extension, $extension, ++$i);
            };
        }
        return $newName;
    }

    private function removeExtension($fileName) {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
}