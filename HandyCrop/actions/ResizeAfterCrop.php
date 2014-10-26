<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rahul
 * Date: 11/13/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */

class ResizeAfterCrop extends CAction{
    public $uploadFolder;
    public $targetWidth;
    public $targetHeight;
    public $thumbnail = false;
    public $thumbnailWidth = 150;
    public $thumbnailHeight = 150;
    public $watermark = false;
    public $watermarkImagePath;

    public function run($attr = null)
    {
        //Prevent multi load of same .js on ajax call
        Yii::app()->clientScript->scriptMap=array(
            (YII_DEBUG ?  'jquery.js':'jquery.min.js')=>false,
        );

        if(isset($_POST['filename'])){
            $folder= Yii::app()->getBasePath() . "/../".$this->uploadFolder."/";// folder for uploaded
            $imagePath = $folder.$_POST['filename'];

            Yii::import('ext.jcrop.EJCropper');
            $jcropper = new EJCropper();
            $jcropper->thumbPath = $folder;

            // some settings ...
            $jcropper->jpeg_quality = 95;
            $jcropper->png_compression = 8;
            /*$jcropper->targ_h = 80;
            $jcropper->targ_w = 320;*/
            $jcropper->targ_h = $this->targetHeight;
            $jcropper->targ_w = $this->targetWidth;
            //Crop and overwrite original image.
            // returns the path of the cropped image, source must be an absolute path.
            $cropped = $jcropper->crop($imagePath, array('x'=>$_POST['x1'], 'y'=>$_POST['y1'], 'h'=>$_POST['h'], 'w'=>$_POST['w']));

            //****if watermark true, add watermark*******
            if($this->watermark && !empty($this->watermarkImagePath)){
                Yii::import('ext.WideImage.WideImage');

                $img = WideImage::load($imagePath);
                $watermark = WideImage::load($this->watermarkImagePath);
                $img->merge($watermark, 'right-10%', 'bottom-10%', 100)->saveToFile($imagePath);
                //$img->applyMask($watermark,'20', '20')->saveToFile($imagePath);


                //$new = $img->merge($watermark, 'center', 'bottom – 10', 50);

            }

            //****if thubmnail is true then create a thumbnail in the /thumbnail subfolder******
            if($this->thumbnail && file_exists($imagePath)){
                Yii::import('ext.WideImage.WideImage');
                $thumbnailFolder = $folder."thumbnail/";
                //create folder if not exists
                if (!file_exists($thumbnailFolder)) {
                    mkdir($thumbnailFolder, 0766, true);
                }
                $thumbnailImagePath = $thumbnailFolder.$_POST['filename'];

                //copy image to /thumbnail folder
                copy($imagePath, $thumbnailImagePath);

                //Resize copied image
                    WideImage::load($thumbnailImagePath)->resize($this->thumbnailWidth, $this->thumbnailHeight)->saveToFile($thumbnailImagePath);
            }

        }
    }

}