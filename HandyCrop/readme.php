<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rahul - handysolver.com
 * Date: 12/16/13
 * Time: 10:20 AM
 * To change this template use File | Settings | File Templates.
 */

?>

<?php
//********************** extensions **********************
// 1. EAjaxUpload
// 2. jcrop
// 3. WideImage - for watermark & resize
// 4. HandyCrop
?>

<?php

//*********************** main.php ****************************
return array(
    'import'=>array(
        'ext.HandyCrop.HandyCrop',
    ),
);
?>
<?php //***************** view.php ******************************** ?>
<?php
//Prepare: default Image, or load previous image
//$defaultImage = '<i class="icon-user" style="font-size: 125px;"></i>';
$defaultImage='<div class="editable-image"><span><input type="hidden" name="avatar-hidden" value=""></span><span><div class=" ace-file-multiple" style="width: 150px;"><label class="avatar-label" data-title="Change Avatar"><span data-title="No File ..."><i class="icon-picture"></i></span></label></div></span></div>';

if(!empty($model->profile_image)){
?>
<span id="deleteImage" style="position: absolute;opacity:0.8;">
    <?php if($model->profile_image):?>
        <?php //Delete Photo ?>
        <?php echo CHtml::link('Delete Image', array('//talent/toolTalent/handyCropDelete','id'=>$model->id), array(
            'confirm' => 'Are you sure?',
            'class'=> 'btn btn-small btn-warning color1 small',
        )); ?>
    <?php endif;?>
</span>
<?php
    $imageUrl = Yii::app()->baseUrl."/profileimage/".$model->profile_image;
    $defaultImage = "<div style='width:100%'><img src='".$imageUrl."?".rand(1,100)."' style='max-width: 150;'></div>";
    $defaultImage.= '<div class="clearfix"></div>';
    $defaultImage.= '<div class="editable-buttons" style="display: block;text-align: center">
            <button type="button" name="delete-profile-image" class="btn delete-profile-image" style="margin: 0;margin-top: 5px;"><i class="icon-remove"></i></button>
        </div>';
}
?>

<?php
//use widget in view file
$random = rand(10000,32000);//random ids Allows Multiple handyCrops on single page.
$this->beginWidget('ext.HandyCrop.HandyCrop', array(
    'defaultImage'=>$defaultImage,
    'uploadUrl' => Yii::app()->createUrl('account/upload'),//suppose account is your controller
    'cropUrl' => Yii::app()->createUrl('account/crop'),
    'resizeAfterCropUrl' => Yii::app()->createUrl('account/resizeAfterCrop'),
    'random'=>$random,
)); ?>

<?php $this->endWidget(); ?>

<?php echo $form->hiddenField($model,'profile_image') ?>


<?php //*********************controller.php***************************** ?>
<?php
class AccountController extends Controller
{
    const UPLOAD_FOLDER = "item-image";

    //point this controller's actions to the widget's actions, with some property initializations
    public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'ext.HandyCrop.actions.Upload',
                'uploadFolder'=>self::UPLOAD_FOLDER,
            ),
            'crop'=>array(
                'class'=>'ext.HandyCrop.actions.Crop',
                'resizeAfterCropUrl'=>Yii::app()->createUrl('item/resizeAfterCrop'),
                'uploadFolder'=>self::UPLOAD_FOLDER,
                'filenameHiddenField'=>'#Item_image',//'Item' model, 'image' attr
                'targetWidth'=>350,
                'targetHeight'=>350
            ),
            'resizeAfterCrop'=>array(
                'class'=>'ext.HandyCrop.actions.ResizeAfterCrop',
                'uploadFolder'=>self::UPLOAD_FOLDER,
                'targetWidth'=>350,
                'targetHeight'=>350,
                'thumbnail'=>true,
                'thumbnailWidth'=>150,
                'thumbnailHeight'=>150,
                'watermark'=>true,
                'watermarkImagePath'=>Yii::app()->getBasePath() . "/../images/yontro-watermark.png",
                //'watermarkImagePath'=>Yii::app()->getBasePath() . "/../images/6-logo.gif",
            ),
        );
    }

    //add to access rules
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform following
                'actions'=>array('upload','crop','resizeAfterCrop','handyCropDelete'),
                'users'=>array('@'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    //Delete
    public function actionHandyCropDelete($id){
        $model = ToolTalent::model()->findByAttributes(array(
            'id' => $id,
            'user_id' => Yii::app()->user->id,
        ));

        if(isset($model)){
            HandyCrop::deleteFile($model->profile_image, self::UPLOAD_FOLDER);//**IMP**
            $model->profile_image = null;
            $model->save(false);
        }

        //Redirect to update page
        $this->redirect(array('update','id'=>$id));
    }

}
?>
<?php //************************************************** ?>
