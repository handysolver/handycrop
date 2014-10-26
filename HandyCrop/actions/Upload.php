<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rahul
 * Date: 11/13/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */

class Upload extends CAction{

    public $uploadFolder;
    public $fileSize = 2;

    public function run($attr = null)
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder= Yii::app()->getBasePath() . "/../".$this->uploadFolder."/";// folder for uploaded

        //create folder if not exists
        if (!file_exists($folder)) {
            mkdir($folder, 0766, true);
        }

        $allowedExtensions = array("jpg","jpeg","png","JPG","JPEG","PNG","gif","GIF");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit =$this->fileSize * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

        //$newFileName = Yii::app()->user->klanten->klantid.'_logo';

        //delete existing image uploaded by the same filename
        /*$files = glob($folder.Yii::app()->user->klanten->klantid.'_logo*');
        for($i=0; $i<count($files); $i++){
            if(is_file($files[$i]))
                unlink($files[$i]);
        }*/
        $result = $uploader->handleUpload($folder,true,null);//upload

        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $return;// it's array
    }

}