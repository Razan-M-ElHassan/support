<div class="pagetitle">
	<h1>الإعدادات</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">الإعدادات</li>
		</ol>
	</nav>
</div><!-- End Page Title -->
<section class="section staff_info">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body" id="staff_settings">
					<div class="alert alert-dismissible fade show mt-2" role="alert">
						<?php echo (empty($this->config_item['Error']))?"":$this->config_item['Error'];?>
					</div>
					<form class="g-3 mb-3" id="config_form" method="post" action="<?php echo URL?>configuration"  enctype="multipart/form-data">
						<input type="hidden" class="hid_info" id="csrf" name="csrf" value="<?php echo session::get('csrf'); ?>" />
						<div class="row mb-3">
							<div class="col-sm">
								<img id="new_pro_image" src="<?php echo URL."public/IMG/".$this->config_item["LOGO"]['NAME'];?>" width="150px" height="150px" class="img-thumbnail rounded-circle mb-3" alt="..."> <br />
								<input type="file" name="new_pro_image" class="form-control-small file-upload image_upload form-control-file" data-id="new_pro_image" id="img" accept="image/*">
								<div class="d-none err_notification" id="valid_new_pro_image">this field required</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm">
								<label for="title" class="">عنوان الموقع</label>
								<input type="text" value="<?php echo $this->config_item["TITLE"]['NAME'];?>" class="form-control" name="title" id="title" placeholder=" العنوان" required />
								<div class="err_notification" id="valid_title">this field required</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm">
								<label for="desc" class="">وصف الموقع</label>
								<input type="text" value="<?php echo $this->config_item["DESC_INFO"]['NAME'];?>" class="form-control" name="desc" placeholder=" الوصف" required />
								<div class="err_notification" id="valid_desc">this field required</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm col-lg-3 mb-3">
								<label for="phone" class="">رقم الهاتف</label>
								<input type="text" value="<?php echo $this->config_item["PHONE"]['NAME'];?>" class="form-control" name="phone" placeholder="phone" required />
								<div class="err_notification" id="valid_phone">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="email" class="">البريد الالكتروني</label>
								<input type="text" value="<?php echo $this->config_item["EMAIL_ADD"]['NAME'];?>" class="form-control" name="email" placeholder="email" required />
								<div class="err_notification" id="valid_email">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="paging" class="">عدد البيانات في الصفحة</label>
								<input type="text" value="<?php echo $this->config_item["PAGING"]['NAME'];?>" class="form-control" name="paging" placeholder=" العرض في الصفحة" >
								<div class="err_notification" id="valid_paging">this field required</div>
							</div>
						</div>					
						<div class="row"><div class="col-sm col-lg-3 mb-3"><b>إعدادات البريد الالكتروني</b></div>
						<div class="row">
							<div class="col-sm col-lg-3 mb-3">
								<label for="email_host" class="">الخادم</label>
								<input type="text" value="<?php echo $this->config_item["EMAIL_HOST"]['NAME'];?>" class="form-control" name="email_host" placeholder="URL" required />
								<div class="err_notification" id="valid_email_host">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="email_port" class="">بوابة الخادم</label>
								<input type="number" min="1" max="1000" value="<?php echo $this->config_item["EMAIL_PORT"]['NAME'];?>" class="form-control" name="email_port" placeholder="Port No" required />
								<div class="err_notification" id="valid_email_port">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="email_add" class="">البريد الالكتروني للارسال</label>
								<input type="email" value="<?php echo $this->config_item["EMAIL_SEND_ADD"]['NAME'];?>" class="form-control" name="email_add" placeholder="email" required />
								<div class="err_notification" id="valid_email_add">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="email_pass" class="">كلمة مرور البريد الالكتروني</label>
								<input type="password" value="<?php echo $this->config_item["EMAIL_SEND_PASS"]['NAME'];?>" class="form-control" name="email_pass" placeholder=" كلمة المرور" >
								<div class="err_notification" id="valid_email_pass">this field required</div>
							</div>
						</div>					
						<div class="row"><div class="col-sm col-lg-3 mb-3"><b>روابط التواصل الاجتماعي</b></div>
						<div class="row">
							<div class="col-sm col-lg-3 mb-3">
								<label for="face" class="">Facebook</label>
								<input type="url" value="<?php echo $this->config_item["FACEBOOK"]['NAME'];?>" class="form-control" name="face" placeholder="URL" required />
								<div class="err_notification" id="valid_face">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="twitter" class="">Twitter</label>
								<input type="url" value="<?php echo $this->config_item["TWITTER"]['NAME'];?>" class="form-control" name="twitter" placeholder="URL" required />
								<div class="err_notification" id="valid_twitter">this field required</div>
							</div>
							<div class="col-sm col-lg-3 mb-3">
								<label for="inst" class="">Instegram</label>
								<input type="url" value="<?php echo $this->config_item["INSTAGRAM"]['NAME'];?>" class="form-control" name="inst" placeholder="URL" required />
								<div class="err_notification" id="valid_inst">this field required</div>
							</div>
						</div>					
						<div class="row mb-3">
							<div class="col-sm">
								<label for="login_msg" class="">التزييل</label>
								<textarea class="form-control" name="login_msg" placeholder=" اكتب الرسالة" value="<?php echo session::get("LOGIN_FOOTER");?>"><?php echo session::get("LOGIN_FOOTER");?></textarea>
								<div class="err_notification" id="valid_login_msg">this field required d-none</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm">
								<label for="desc" class="">الشروط والاحكام</label>
								<textarea value="" class="form-control terms_policy" id="terms" name="terms" placeholder=" العرض في الصفحة" ><?php echo $this->config_item['TERMS']['NAME'];?></textarea>
								<div class="err_notification" id="valid_desc">this field required</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm">
								<label for="about" class="">عن الموقع</label>
								<textarea value="" class="form-control terms_policy" name="about" placeholder=" العرض في الصفحة" ><?php echo $this->config_item['ABOUT']['NAME'];?></textarea>
								<div class="err_notification" id="valid_desc">this field required</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-sm">
								<button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> حفظ البيانات</button>
							</div>
						</div>
						<div class="row mt-3">
							<h4>حذف جميع بيانات الموقع</h4> <hr>
						<?php
							if(session::get('user_id') == 1)
							{
						?>
							<div class="col-sm">
								<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del_data"><i class="bi bi-trash"></i> مسح جميع بيانات الموقع </button>
							</div>
						<?php
							}
						?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal For del all data -->
<div id="del_data" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="del_data_title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<form class="row g-3 model_form" id="del_data_form" method="post" action="<?php echo URL?>configuration/del" data-model="del_data" data-type="new" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="del_data_title"><i class="bi bi-trash"></i> مسح بيانات الموقع</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle-fill"></i></button>
				</div>
				<div class="container"></div>
				<div class="modal-body" style="">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<div class="row">
						<div class="col-sm mb-3">
							<h4 class="text-danger">هل انت متأكد من مسح جميع بيانات الموقع؟</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm mt-3">
							<label for="psw" class="form-label">كلمة المرور</label>
							<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
							<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
						</div>		
					</div>
					<div class="row">
						<div class="col-6 mt-3">
							<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
						</div>
						<div class="col-6 mt-3">
							<img src="<?php echo URL?>login/img" class="col-sm-6 img-thumbnail" />
						</div>
					</div>
					<div class="form_msg d-none">تم مسح البيانات</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger mb-3"><i class="bi bi-trash"></i> مسح البيانات</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>