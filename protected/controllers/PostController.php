<?php

class PostController extends Controller
{

    /**
     * Upload Image
    */
    public function actionImgUpload($file)
    {
        
        $webroot = Yii::getPathOfAlias('webroot');
        $dstDir = '/uploads/';

        if (!is_dir($webroot . $dstDir)) {
            mkdir($webroot . $dstDir, 0777, true);
        }

        $ext = $file->getExtensionName();
        $name = $file->name;
        if (strlen($ext)) $name = substr($name, 0, -1 - strlen($ext));

        for ($i = 1, $filePath = $dstDir . $name . '.' . $ext; file_exists($webroot . $filePath); $i++) {
            $filePath = $dstDir . $name . " ($i)." . $ext;
        }

        $file->saveAs($webroot . $filePath);
        return array($filePath, $file->name);
    }

    // /**
    //  * Upload File
    // */
    // public function actionFileUpload($attr)
    // {
    //     //$this->dd($attr);
    //     $this->dd($_FILES);
    //     exit;
    //     $webroot = Yii::getPathOfAlias('webroot');
    //     $dstDir = '/uploads/';

    //     if (!is_dir($webroot . $dstDir)) {
    //         mkdir($webroot . $dstDir, 0777, true);
    //     }

    //     $ext = $file->getExtensionName();
    //     $name = $file->name;
    //     if (strlen($ext)) $name = substr($name, 0, -1 - strlen($ext));

    //     for ($i = 1, $filePath = $dstDir . $name . '.' . $ext; file_exists($webroot . $filePath); $i++) {
    //         $filePath = $dstDir . $name . " ($i)." . $ext;
    //     }

    //     $file->saveAs($webroot . $filePath);
    //     return array($filePath, $file->name);
    // }
    
}