<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="<?php echo URL."public/IMG/".session::get("LOGO");?>" rel="icon">
		<link href="<?php echo URL."public/IMG/".session::get("LOGO");?>" rel="apple-touch-icon">
		<meta name="description" content="<?php echo session::get("DESC_INFO");?>">
		<meta name="keywords" content="<?php echo session::get("DESC_INFO");?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?php echo session::get("TITLE");?></title>
		
		<!-- Vendor CSS Files -->
		<link href="<?php echo URL ?>public/vendor/bootstrap/css/bootstrap.rtl.min.css" rel="stylesheet"->
		<link href="<?php echo URL ?>public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo URL?>public/CSS/bootstrap-datetimepicker.css" />
		<link href="<?php echo URL ?>public/CSS/jquery-ui.min.css" type="text/css">
		<link href="<?php echo URL ?>public/CSS/style.css" rel='stylesheet' type="text/css" >
		<link href="<?php echo URL ?>public/CSS/loader.css" type="text/css" >
		
		<!--
		
		
		<link href="<?php echo URL ?>public/CSS/paging.css" rel='stylesheet' type="text/css" --
		<link href="<?php echo URL ?>public/CSS/main.css" rel='stylesheet' type="text/css" >
		
		<!-- Template Main CSS File -->
		<?php
			if(isset($this->CSS))
			{
				foreach($this->CSS as $v)
				{
					echo '<link rel="stylesheet" href="'.URL.$v.'">';
				}
			}
		?>
		
	</head>
	<body  style="margin:0;"> <!--onload="MY_loader()"-->
	<div id="loader"></div>
	<vue-element-loading :active="show" is-full-screen />
	