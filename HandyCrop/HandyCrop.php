<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rahul
 * Date: 11/12/13
 * Time: 4:26 PM
 * To change this template use File | Settings | File Templates.
 */

class HandyCrop extends CWidget {

    public $uploadUrl;
    public $cropUrl;
    public $resizeAfterCropUrl;
    public $defaultImage;
    public $thumbnail = false;
    public $random;

    public function init()
    {
        // this method is called by CController::beginWidget()
        //custom init stuff

        return parent::init();
    }

    public function run(){
        // this method is called by CController::endWidget()

        $assets = dirname(__FILE__).'/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        Yii::app()->clientScript->registerScriptFile($baseUrl.'/jcrop/jquery.Jcrop.min.js');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/jcrop/jquery.Jcrop.css');

        $this->render('uploadAndCrop',array('random'=>$this->random));
    }

    public static function deleteFile($filename,$uploadFolder){
        $image = Yii::app()->getBasePath() . '/../' . $uploadFolder . '/' . $filename; // folder for uploaded
        $imageThumbnail = Yii::app()->getBasePath() . '/../' . $uploadFolder . '/thumbnail/' . $filename; // folder for uploaded
        //delete existing image uploads for that user if any exist

        if (is_file($image))
            unlink($image); // delete file

        if (is_file($imageThumbnail))
            unlink($imageThumbnail); // delete file
    }

}