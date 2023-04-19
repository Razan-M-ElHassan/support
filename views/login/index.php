<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="<?php echo URL."public/IMG/".session::get("LOGO");?>">
		<meta name="description" content="<?php echo session::get("DESC_INFO");?>">
		<meta name="keywords" content="<?php echo session::get("DESC_INFO");?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?php echo session::get("TITLE")?></title>
		
		<!-- Vendor CSS Files -->
		<link href="<?php echo URL ?>public/vendor/bootstrap/css/bootstrap.rtl.min.css" rel="stylesheet">
		<link href="<?php echo URL ?>public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
		
		<!-- Template Main CSS File -->
		<link href="<?php echo URL ?>public/CSS/style.css" rel="stylesheet">
	</head>
	<body>
		<main>
			<div class="container">
				<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center text-center justify-content-center">
								<div class="d-flex justify-content-center py-1">
									<a href="<?php echo URL?>" class=" d-flex align-items-center">
										<img src="<?php echo URL."public/IMG/".session::get("LOGO");?>" alt="logo" height="150px" width="150px" class="">
									</a>
								</div><!-- End Logo -->
								<!--p><?php echo session::get("TITLE")?></p-->
								<p>منصة توظيف الكفاءات .. منصة خاصة بخريجي برنامج الكفاءة الاستراتيجية</p>
								<div class="card mb-3">
									<div class="card-body">
										<div class="pb-2">
											<h5 class="card-title text-center pb-0 fs-4">تسجيل الدخول</h5>
											<!--p class="text-center small">ادخل اسم المستخدم وكلمة المرور الخاصة بك</p-->
										</div>
										
										<?php 
											if(!empty($this->MSG))
											{
										?>
												<div class="pb-2">
													<p class="card-title text-center text-danger pb-0 fs-6"><?php echo $this->MSG?></p>
												</div>
										<?php
											}
										?>
										
										<form action="<?php echo URL?>login/login" method="post" class="row g-3 needs-validation" novalidate>
											<input type="hidden" name="csrf" value="0" />
											<div class="col-12">
												<!--label for="usrname" class="form-label">اسم المستخدم</label-->
												<div class="input-group has-validation">
													<!--span class="input-group-text" id="inputGroupPrepend">@</span-->
													<input type="text" name="usrname" class="form-control" id="usrname" placeholder="اسم المستخدم" required>
													<div class="invalid-feedback">من فضلك ادخل اسم المستخدم.</div>
												</div>
											</div>
											<div class="col-12">
												<!--label for="psw" class="form-label">كلمة المرور</label-->
												<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
												<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
											</div>											
											<div class="col-12">
												<div class="row">
													<div class="col-6">
														<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
													</div>
													<div class="col-6">
														<img src="<?php echo URL?>login/img" class="col-sm-8 img-thumbnail" />
													</div>
												</div>
											</div>
											<div class="col-12 mt-3">
												<button class="btn btn-primary w-100" type="submit">تسجيل دخول</button>
											</div>
											<div class="col-12 mt-3">
												<a href="<?php echo URL?>login/forget" class="btn w-100" >نسيت كلمة المرور؟</a>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="text-sm-center">
							<h6><?php echo str_replace("\n","<br/>",session::get("LOGIN_FOOTER"));?></h6>
						</div>
					</div>
				</section>
			</div>
		</main><!-- End #main -->
	</body>
</html>