<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="<?php echo URL."public/IMG/".session::get("LOGO");?>">
		<meta name="description" content="<?php echo session::get("DESC_INFO");?>">
		<meta name="keywords" content="<?php echo session::get("DESC_INFO");?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?php echo session::get("TITLE");?></title>
		
		<!-- Vendor CSS Files -->
		<link href="<?php echo URL ?>public/vendor/bootstrap/css/bootstrap.rtl.min.css" rel="stylesheet">
		<link href="<?php echo URL ?>public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
		<link href="<?php echo URL ?>public/CSS/main.css" rel='stylesheet' type="text/css" >

		<!-- Template Main CSS File -->
		<link href='<?php echo URL ?>public/CSS/style.css' rel='stylesheet'>
	</head>
	<body>
		<main>
			<div class="container">
				<section class="property-section spad vue_area_div">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-5 col-md-7 d-flex flex-column align-items-center justify-content-center">
								<div class="d-flex justify-content-center py-4">
									<a href="<?php echo URL ?>" class="logo d-flex align-items-center w-auto">
										<img src="<?php echo URL."public/IMG/".session::get("LOGO");?>" alt="" class="">
										<!--span class="d-none d-lg-block"><?php echo session::get("TITLE");?> </span-->
									</a>
								</div><!-- End Logo -->

								<div class="card mb-3">
									<div class="card-body">
										<div class="pb-2">
											<h5 class="card-title text-center pb-0 fs-4">فتح حساب جديد</h5>
											<!--p class="text-center small">ادخل اسم المستخدم وكلمة المرور الخاصة بك</p-->
										</div>
									<?php 
										if(!empty($this->MSG))
										{
									?>
										<div class="pb-2">
											<p class="card-title text-center pb-0 fs-4"><?php echo $this->MSG?></p>
										</div>
									<?php
										}
									?>
										<form action="<?php echo URL?>login/reg" method="post" class="row g-3 needs-validation">
											<input type="hidden" name="csrf" value="0" />
											<div class="col-12">
												<label for="usrname" class="form-label">الإسم</label>
												<div class="input-group has-validation">
													<!--span class="input-group-text" id="inputGroupPrepend">@</span-->
													<input type="text" name="usrname" class="form-control" id="usrname" placeholder="اسم المستخدم" required>
													<div class="invalid-feedback">من فضلك ادخل اسمك.</div>
												</div>
											</div>
											<div class="col-12">
												<label for="email" class="form-label">البريد الإلكترونى</label>
												<div class="input-group has-validation">
													<!--span class="input-group-text" id="inputGroupPrepend">@</span-->
													<input type="email" name="email" class="form-control" id="email" placeholder="البريد الإلكترونى" required>
													<div class="invalid-feedback">من فضلك ادخل اسمك.</div>
												</div>
											</div>
											<div class="col-12">
												<label for="phone" class="form-label">رقم الهاتف</label>
												<div class="input-group has-validation">
													<!--span class="input-group-text" id="inputGroupPrepend">@</span-->
													<input type="phone" class="form-control" id="phone" name="phone" placeholder="رقم الهاتف">
													<div class="invalid-feedback">من فضلك ادخل اسمك.</div>
												</div>
											</div>
											<div class="col-12">
												<label for="psw" class="form-label">تأكيد كلمة المرور</label>
												<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
												<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
											</div>
											<div class="col-12">
												<label for="psw2" class="form-label">كلمة المرور</label>
												<input type="password" name="psw2" class="form-control" id="psw2" placeholder="تأكيد كلمة المرور" required>
												<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
											</div>
											<div class="col-12">
												<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
												<img src="<?php echo URL?>login/img" class="col-4 mt-2 col-form-label" />
											</div>
											<div class="col-12">
												<input type="checkbox" class="" id="accept" name="accept" placeholder="أوافق على الشروط والاحكام" value="1" />
												أوافق على 
												<a href="<?php echo URL?>dashboard/terms" target="_blank"> الشروط والاحكام</a>
											</div>
											<div class="col-12">
												<button class="btn btn-bg w-100 login_button" type="submit">تسجيل</button>
											</div>
											<div class="col-12">
												<a href="<?php echo URL?>login/" class="btn btn-bg w-100">لديك حساب؟</a>
											</div>
										</form>
									</div>
								</div>
								<div class="credits">
									كل الحقوق محفوظة
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</main><!-- End #main -->
	    <div class="d-none" id="targetLayer"></div>
		<script type="text/javascript">
			var URL = "<?php echo URL?>";
			var E_HIDE = "d-none";
		</script>
		<!-- Js Plugins -->
		<script src="<?php echo URL?>public/JS/vue.min.js"></script>	
		<script src="<?php echo URL?>public/JS/jquery/jquery-3.3.1.min.js"></script>
		<script src="<?php echo URL?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!--script src="<?php echo URL?>public/JS/js/mixitup.min.js"></script-->
		<script src="<?php echo URL?>public/JS/jquery/jquery-ui.min.js"></script>
		
		<script src="<?php echo URL?>public/JS/jquery/jquery.form.js"></script>

		<!--script src="<?php echo URL?>public/JS/js/owl.carousel.min.js"></script-->
		<script src="<?php echo URL?>public/JS/main.js"></script>
		<script src="<?php echo URL?>public/JS/main2.js"></script>
		
		<script src="<?php echo URL?>public/JS/default.js"></script>
	    <script src="<?php echo URL?>views/login/JS/login.js"></script>
	</body>
</html>