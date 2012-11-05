<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
	$header_title = (isset($header_title)) ? $header_title : "" ;
	$css_files = (isset($groceryCRUD_output->css_files)) ? $groceryCRUD_output->css_files : array() ;
	$js_files = (isset($groceryCRUD_output->js_files)) ? $groceryCRUD_output->js_files : array() ;
	?>
	<title><?php echo $header_title ?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/jq/jquery.countdown.css" type="text/css" media="screen" />	
	
	<?php foreach($css_files as $file): ?>
	<link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" media="screen"/>
	<?php endforeach; ?>
	
	<!--<script src="<?php echo base_url();?>assets/grocery_crud/js/jquery-1.8.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>-->
	<script src="<?php echo base_url();?>js/jq/jquery-1.8.2.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url();?>js/utils/cookieutils.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url();?>js/cd/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url();?>js/utils/dateutils.js" type="text/javascript" charset="utf-8"></script>
	
		
	<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>" type="text/javascript" charset="utf-8"></script>
	<?php endforeach; ?>
</head>
<body><!--end header-->