<!--Display image-->
<!--<div class="span3">-->
<span id="displayImage<?php echo $random;?>">
    <?php echo $this->defaultImage; ?>
</span>

    <div class="space-4"></div>

    <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
        array(
            'id'=>'uploadFile'.$random,
            'config'=>array(
                'action'=>$this->uploadUrl,
                'qq-upload-button' => 'Upload',
                'allowedExtensions'=>array("jpg","jpeg","png","gif","JPG","JPEG","PNG","GIF"),//array("jpg","jpeg","gif","exe","mov" and etc...
                'sizeLimit'=>5*1024*1024,// maximum file size in bytes
                //'minSizeLimit'=>.1*1024*1024,// minimum file size in bytes
                'onComplete'=>"js:function(id, fileName, responseJSON){
                            $('#cropDialog".$random."').dialog('open');
                            $('#cropImg".$random."').load('". $this->cropUrl ."?random=".$random."&filename='+encodeURIComponent(responseJSON.filename),function(){\$('#cropDialog".$random."').dialog('option', 'position', 'top');});
	                    }",
            )
        )); ?>
    <!-- the crop modal -->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'cropDialog'.$random,
            'options'=>
            array(
                'title'=>'Crop',
                'modal'=>true,
                'width'=>'auto',
                /* 'height'=>600, */
                'autoOpen'=>false,
            )
        ));

    echo "<div id='cropImg".$random."'></div>";

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>

<!--</div>-->
<style>
    .qq-uploader {
        display: none!important;
    }
</style>
<script>
    $(function(){
        $('#displayImage<?php echo $random;?>').live('click',function(){
            $('#uploadFile<?php echo $random; ?> input[name="file"]').trigger('click');
        });
    })
</script>