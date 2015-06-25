
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!--<link rel="shortcut icon" href="<?php //echo HTTP_ROOT ?>img/favicon.ico" type="image/x-icon">-->
<title>Meeting Leader | Admin Panel</title>
<!--<link href="<?php //echo HTTP_ROOT?>css/admin/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/morris/morris.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<link href="<?php //echo HTTP_ROOT?>css/admin/AdminLTE.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php //echo HTTP_ROOT?>css/admin/style.css" media="screen" />-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!--<script src="<?php echo HTTP_ROOT?>js/admin/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<script src="<?php //echo HTTP_ROOT?>js/admin/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php //echo HTTP_ROOT?>js/admin/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php //echo HTTP_ROOT?>js/admin/AdminLTE/demo.js" type="text/javascript"></script>-->



<?php  
	echo $this->Html->css('admin/bootstrap.css');
	echo $this->Html->css('admin/bootstrap.min.css');
	echo $this->Html->css('admin/font-awesome.css');
	echo $this->Html->css('admin/ionicons.min.css');
	echo $this->Html->css('admin/morris/morris.css');
	echo $this->Html->css('admin/jvectormap/jquery-jvectormap-1.2.2.css');
	echo $this->Html->css('admin/AdminLTE.css');
	echo $this->Html->css('admin/style.css');
	
	
	
	echo $scripts_for_layout;
	echo $this->Html->script('admin/jquery-ui-1.10.3.min.js');
	echo $this->Html->script('admin/jquery.validate.js');
?> 
</head>
<body class="skin-blue">
<!-- Main --> 
<?php
	echo $this->element('adminElements/header'); 
	echo $content_for_layout; 
	echo $this->element('adminElements/footer'); 
?> 

<!-- Main -->
</body>
</html>
