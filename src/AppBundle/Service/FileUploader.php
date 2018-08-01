<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 29.1.2018 г.
 * Time: 10:17 ч.
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public  function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file){
        $fileName = md5(uniqid() . '.' . $file->getExtension());
        $file->move($this->targetDir,$fileName);

        return $fileName;
    }

    public function getTargetDir(){
        return $this->targetDir;
    }
}