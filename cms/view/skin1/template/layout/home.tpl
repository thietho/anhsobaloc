<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta http-equiv="REFRESH" content="5400" />
<meta name="description" content="<?php echo $meta_description?>" />
<meta name="keywords" content="<?php echo $meta_keyword?>" />		
<title><?php echo $title ?></title>

</head>


<link href="<?php echo DIR_VIEW?>css/ie_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo DIR_VIEW?>js/ie_png.js"></script>
<script type="text/javascript">
   ie_png.fix('.png, #content .pagenavi, .aside ');
</script>


<link rel='stylesheet' type='text/css' href='<?php echo DIR_VIEW?>css/style.css'>
<link rel='stylesheet' type='text/css' href='<?php echo DIR_VIEW?>css/layout.css'>
<link rel='stylesheet' type='text/css' href='<?php echo DIR_VIEW?>css/jquery-ui.css'>
<script type='text/javascript' language='javascript' src='<?php echo DIR_VIEW?>js/maxheight.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo DIR_VIEW?>js/ajaxupload.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo DIR_VIEW?>js/common.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo DIR_VIEW?>js/jquery-1.4.2.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo DIR_VIEW?>js/ui.datepicker.js'></script>

<script type='text/javascript' language='javascript' src='<?php echo DIR_COMPONENT?>ckeditor/ckeditor.js'></script>


<body onload="new ElementMaxHeight();">
<div id="main">
    <!----------------------------- header ------------------------------------->
    <?php echo $header?>		
   	<!--header end-->
    <div id="content"> 
    <?php echo $menu?>
    <!------------------------- content wrapper ---------------------------->
    <div class="wrapper-content">
    	<div class="aside maxheight">
        	<?php echo $dashboard?>
        </div>
        <div class="content">
        	<?php echo $content?>
            <!-- main content end -->
        </div>
        <div class="clear"></div>
    </div>    
	<!------------------------ content wrapper end ------------------------>	
    </div>
    <?php echo $footer?>
</div>

</body>

</html>
