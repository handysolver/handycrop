<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rahul
 * Date: 11/13/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */

class Crop extends CAction{

    public $resizeAfterCropUrl;
    public $uploadFolder;
    public $filenameHiddenField;
    public $targetWidth;
    public $targetHeight;
    public $maintainAspectRatio = true;

    public function run($attr = null)
    {
        $random = $_GET['random'];

        //Prevent multi load of same .js on ajax call
        /*Yii::app()->clientScript->scriptMap=array(
            (YII_DEBUG ?  'jquery.js':'jquery.min.js')=>false,
        );*/

        /*Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.notify.js'] = false;

        Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;*/
        //Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/style.min.css');
        //Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/style-responsive.min.css');

        //$this->controller->render('crop', array('imageUrl'=>$imageUrl), false, true);
        Yii::app()->controller->renderFile(Yii::app()->basePath.'/extensions/HandyCrop/views/crop.php',array(
            'resizeAfterCropUrl'=>$this->resizeAfterCropUrl,
            'uploadFolder'=>$this->uploadFolder,
            'filenameHiddenField'=>$this->filenameHiddenField,
            'targetWidth'=>$this->targetWidth,
            'targetHeight'=>$this->targetHeight,
            'maintainAspectRatio'=>$this->maintainAspectRatio,
            'random'=>$random
        ));

    }

}