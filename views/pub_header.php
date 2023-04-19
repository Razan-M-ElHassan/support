<!DOCTYPE html>
<html lang="ar" dir="rtl">
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
		<link href="<?php echo URL ?>public/CSS/main.css" rel='stylesheet' type="text/css" >
		<link href="<?php echo URL ?>public/CSS/loader.css" type="text/css" >
		
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
	<!-- ======= Header ======= -->
		<header id="header" class="header fixed-top">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container-fluid">
					<a href="<?php echo URL?>" class="navbar-brand logo">
						<img src="<?php echo URL."public/IMG/".session::get("LOGO");?>" alt="logo" class="">
						<!--span class="d-none d-lg-block"><?php echo session::get("TITLE");?></span-->
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link " href="<?php echo URL?>dashboard">الرئيسية</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo URL?>dashboard/about">من نحن</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo URL?>dashboard/terms">الشروط والاحكام</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo URL?>dashboard/contact">اتصل بنا</a>
							</li>
						</ul>
						<div class="d-flex" >
							<a class="btn btn-block btn-outline-primary" href="<?php echo URL?>login">دخول</a>
						</div>
					</div>
				</div>
			</nav>
		</header><!-- End Header -->

		<main id="main" class="main vue_area_div area_view">