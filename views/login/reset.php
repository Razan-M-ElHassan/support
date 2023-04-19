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
		
		<!-- Template Main CSS File -->
		<link href='<?php echo URL ?>public/CSS/style.css' rel='stylesheet'>
	</head>
	<body>
		<main>
			<div class="container">
				<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
								<div class="d-flex justify-content-center py-4">
									<a href="<?php echo URL ?>" class="logo d-flex align-items-center w-auto">
										<img src="<?php echo URL."public/IMG/".session::get("LOGO");?>" alt="" class="">
										<span class="d-none d-lg-block  log"><?php echo session::get("TITLE");?> </span>
									</a>
								</div><!-- End Logo -->

								<div class="card mb-3">
									<div class="card-body">
										<div class="pb-2">
											<h5 class="card-title text-center pb-0 fs-4">اعادة ضبط كلمة المرور</h5>
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
										}else{
									?>
										<form id="reset_form" action="<?php echo URL?>login/update_res_password" method="post" class="row g-3 needs-validation" novalidate>
											<input type="hidden" name="csrf" value="0" />
											<input type="hidden" name="id" value="<?php echo $this->id ;?>" />
											<div class="col-12">
												<label for="psw" class="form-label">كلمة المرور</label>
												<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
												<div id="valid_psw" class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
											</div>
											<div class="col-12">
												<label for="psw2" class="form-label">تأكيد كلمة المرور</label>
												<input type="password" name="psw2" class="form-control" id="psw2" placeholder="كلمة المرور" required>
												<div id="valid_psw2" class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
											</div>
											<div class="col-12">
												<button id="forget_send" type="submit" class="btn btn-block create-account btn-primary mb-2">إرسال</button>
											</div>
										</form>
									<?php
										}
									?>
									</div>
								</div>
								<div class="credits">
									كل الحقوق محفوظة
								</div>
							</div>
						</div>
					</div>
					<!-- Model For Errors -->
					<div id="reset_req_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<p>لقد تم اعادة ضبط كلمة المرور</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</main><!-- End #main -->
	    <div class="d-none" id="targetLayer"></div>
		<script type="text/javascript">
			var MAIN_URL = "<?php echo URL?>";
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
