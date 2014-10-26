<style>
/************** PREVENTS SQUASHING OF CROPPED IMAGE**********************/
img {/* was conflicting with crop css */
max-width : none;
}
</style>

<?php $imageUrl = Yii::app()->baseUrl."/".$uploadFolder."/".$_GET['filename']; ?>

<img src="<?php echo $imageUrl; ?>?<?php echo rand(1,100)?>" style="width:none !important:height: none !important;" id="target<?php echo $random;?>"/>

<form id="coords<?php echo $random;?>" class="coords" style="margin-bottom:0;">
	<input type="hidden" name="filename" value="<?php echo $_GET['filename'];?>" />
    <input type="hidden" id="x1<?php echo $random;?>" name="x1" />
    <input type="hidden" id="y1<?php echo $random;?>" name="y1" />
    <input type="hidden" id="x2<?php echo $random;?>" name="x2" />
    <input type="hidden" id="y2<?php echo $random;?>" name="y2" />
    <input type="hidden" id="w<?php echo $random;?>" name="w" />
    <input type="hidden" id="h<?php echo $random;?>" name="h" />
    <br>
	<input type="submit" value="Crop" class="btn btn-warning">
</form>
<script type="text/javascript">
$('#target<?php echo $random;?>').css('display', '');
$('#target<?php echo $random;?>').css('width', '');
$('#target<?php echo $random;?>').css('height', '');
$('#target<?php echo $random;?>').css('max-width', '');
$('#target<?php echo $random;?>').css('max-height', '');

//Ajax  submit form
$("#coords<?php echo $random;?>").submit(function(e) {
    console.log($("#coords<?php echo $random;?>").serialize());
    e.preventDefault();
    var url = "<?php echo $resizeAfterCropUrl; ?>"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#coords<?php echo $random;?>").serialize(), // serializes the form's elements.
           success: function(data)
           {
               //show image on displayImage
        		$('#displayImage<?php echo $random;?>').html("<img src='<?php echo $imageUrl; ?>?<?php echo rand(1,100)?>' style='padding-bottom: 10px;max-width: <?php echo $targetWidth ?>px;max-height: <?php echo $targetHeight; ?>px;'>");
               $("<?php echo $filenameHiddenField ?>").val("<?php echo $_GET['filename'];?>");
        		//close dialog box
        		$('#cropDialog<?php echo $random;?>').dialog('close');
           }
         });
    return false; // avoid to execute the actual submit of the form.
});
</script>
  
  
<script language="Javascript">
//Jcrop script
$('#target<?php echo $random;?>').on('load',function() {
	$('#target<?php echo $random;?>').Jcrop({
	   onChange:   showCoords,
	   onSelect:   showCoords,
	   onRelease:  clearCoords,
	   bgColor:     'transparent',//'black' was turning Transparent part of PNG to black
	   bgOpacity:   .4,
	   setSelect:   [0,0,<?php echo $targetWidth; ?>,<?php echo $targetHeight; ?>],
       <?php if($maintainAspectRatio): ?>
	   aspectRatio: <?php echo $targetWidth/$targetHeight ?>, //320:80 = 4
       <?php endif; ?>
	   boxWidth: 400, //Max width of loaded image
	   boxHeight: 400, //Max height loaded image
    });
});

/* 	 setTimeout(function () {
	        $('#target<?php echo $random;?>').Jcrop({
	            onChange:   showCoords,
			    onSelect:   showCoords,
			    onRelease:  clearCoords,
	            bgColor:     'black',
	            bgOpacity:   .4,
	         	setSelect:   [ 0, 0, 225, 225 ],
	            aspectRatio: 1
	        });
	}, 250);  */

    // Simple event handler, called from onChange and onSelect
    // event handlers, as per the Jcrop invocation above
    function showCoords(c)
    {
      $('#x1<?php echo $random;?>').val(c.x);
      $('#y1<?php echo $random;?>').val(c.y);
      $('#x2<?php echo $random;?>').val(c.x2);
      $('#y2<?php echo $random;?>').val(c.y2);
      $('#w<?php echo $random;?>').val(c.w);
      $('#h<?php echo $random;?>').val(c.h);
    };

    function clearCoords()
    {
      $('#coords<?php echo $random;?> input').val('');
    };

</script>
