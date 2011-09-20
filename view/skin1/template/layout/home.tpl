<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta http-equiv="REFRESH" content="5400" />
<meta name="description" content="<?php echo $meta_description?>" />
<meta name="keywords" content="<?php echo $meta_keyword?>" />		
<title><?php echo $title?></title>

</head>

<!--[if lt IE 7]>
	<link href="<?php echo DIR_VIEW?>css/ie_style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo DIR_VIEW?>js/ie_png.js"></script>
    <script type="text/javascript">
       ie_png.fix('.png');
	</script>
<![endif]-->

<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_VIEW?>css/style.css'>
<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_CSS?>blockui.css'>
<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_VIEW?>css/jquery-ui.css'>
<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_CSS?>jquery.tabs.css'>

<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/jquery.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_JS?>jquery.blockUI.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/maxheight.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/jquery.tabs.pack.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_COMPONENT?>ckeditor/ckeditor.js'></script>
<script language="javascript">
var HTTP_SERVER = '<?php echo HTTP_SERVER?>';
</script>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/common.js'></script>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/cart.js'></script>



<body>
<div id="ben-main">
    
    <?php echo $header?>
	
	<div id="ben-content">
    	<?php echo $content?>
    </div>
    
    <?php echo $footer?> 

</div>

</body>

</html>
