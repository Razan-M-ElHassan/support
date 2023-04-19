<!-- Contact Section Begin -->
<section class="section contact">
	<div class="container">
		<div class="row gy-4">
			<div class="title">
				<h1 class="display-3 text-bold">تواصل معنا</h1>
				<h5 class="lead text-body-secondary">لاي استفسار الرجاء مراسلتنا.</h5>
			</div>
			<div class="col-xl-6">
				<div class="row">
					<div class="col-lg-6">
						<div class="info-box card">
							<i class="bi bi-geo-alt"></i>
							<h3>العنوان</h3>
							<p><?php echo session::get('ADDRESS')?></p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="info-box card">
							<i class="bi bi-telephone"></i>
							<h3>الهاتف</h3>
							<p><?php echo session::get('PHONE')?></p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="info-box card">
							<i class="bi bi-envelope"></i>
							<h3>البريد الإلكتروني</h3>
							<p><?php echo session::get('EMAIL_ADD')?></p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="info-box card">
							<i class="bi bi-globe"></i>
							<h3>تواصل معنا عبر</h3>
							<p>
								<a href="<?php echo session::get('FACEBOOK')?>" target="_blank">
									<i class="bi bi-facebook"></i>
								</a>
								<a href="<?php echo session::get('TWITTER')?>" target="_blank">
									<i class="bi bi-twitter"></i> 
								</a>
								<a href="<?php echo session::get('INSTAGRAM')?>" target="_blank">
									<i class="bi bi-instagram"></i>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6">
				<div class="card p-4">
					<div><?php echo $this->MSG;?></div>
					<form class="cc-form" id="contact_form" action="<?php echo URL?>dashboard/contact" method="post">
						<div class="row gy-4">
							<input type="hidden" class="hid_info" name="csrf" id="csrf" value="<?php echo lib::get_CSRF(); ?>" />
							<input type="text" name="name" class="form-control " value="<?php echo session::get('user_name'); ?>" placeholder="الاسم" data-rule="minlen:4" data-msg="من فضلك ادخل 3 حروف على الاقل" />
							<div class="err_notification" id="valid_name">
								الرجاء مراجعة هذا الحقل
							</div>
							<input type="email" class="form-control" name="email" value="<?php echo session::get('user_email'); ?>" placeholder="بريدك الإلكتروني" data-rule="email" data-msg="من فضلك ادخل بريدك الإلكتروني" />
							<div class="err_notification" id="valid_email">
								الرجاء مراجعة هذا الحقل
							</div>
							<input type="text" class="form-control" name="subject" placeholder="الموضوع" data-rule="minlen:4" data-msg="من فضلك ادخل 20 حرف على الاقل" />
							<div class="err_notification" id="valid_subject">
								الرجاء مراجعة هذا الحقل
							</div>
							<textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="من فضلك رسالتك" placeholder="اكتب رسالتك هنا..."></textarea>
							<div class="err_notification" id="valid_message">
								الرجاء مراجعة هذا الحقل
							</div>
							<div class="row mt-3">
								<div class="col-sm">
									<input type="txt" class="form-control " name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
								</div>
								<div class="col-sm">
									<img src="<?php echo URL?>login/img" height="90" class="img-thumbnail col-6" />
								</div>
							</div>
							<button type="submit" class="btn btn-primary">ارسال</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Contact Section End -->

<script>
	var js_details		=  {'FILES':[]};
	var js_specialist 	= {};
	var js_area 		= {};
	
</script>