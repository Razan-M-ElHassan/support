<div class="pagetitle">
	<h1>النسخ الإحتياطية</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">النسخ الإحتياطية</li>
		</ol>
	</nav>
</div><!-- End Page Title -->
	
<section class="section vue_area_div" id="info_area">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body table-responsive" id="staff_settings">
					<div class="card-title">
						<button id="add_backup" type="button" class="btn btn-success mb-3 mx-2" v-on:click.prevent="new_backup()" >
							إضافة نسخة احتياطية <i class="bi bi-plus-circle"></i>
						</button>
						<button id="add_backup" type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#upload_backup" >
							تحميل نسخة احتياطية <i class="bi bi-download"></i>
						</button>
					</div>
					<table class="table border-secondary table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>الرقم</th>
								<th>الاسم</th>
								<th colspan="3">الأجراء</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(x ,index) in backup_list">
								<td>{{index + 1}}</td>
								<td>{{x}}</td>
								<td><a class="btn btn-warning rounded btn-sm" target="_blank" :href="'<?php echo URL."backup/get_file/";?>'+x" >تنزيل <i class='fa fa-download'></i></a></td>
								<td><button v-on:click.prevent="del_upd(index)" data-bs-toggle="modal" data-bs-target="#restore" class='btn btn-warning rounded btn-sm '>إسترجاع</button></td>
								<td><button v-on:click.prevent="del_upd(index)" data-bs-toggle="modal" data-bs-target="#del_back" class='btn btn-danger rounded btn-sm '>حذف</button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal del backup -->
<div id="del_back" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="del_back_title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<form class="row g-3 model_form" id="del_back_form" method="post" action="<?php echo URL?>backup/del_backup" data-model="del_back" data-type="new" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="del_back_title"><i class="bi bi-trash"></i> حذف النسخة الاحتياطية</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="container"></div>
				<div class="modal-body" style="">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" class="" name="file_name" :value="file_name" />
					<div class="row">
						<div class="col-sm mb-3">
							<h6 class="text-danger">هل انت متأكد من انك تريد حذف هذه النسخة الاحتياطية  {{file_name}} ؟</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-sm mb-3">
							<label for="psw" class="form-label">ادخل كلمة المرور الخاصة بك ورمز التحقق </label>
							<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
							<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
						</div>		
					</div>
					<div class="row">
						<div class="col-6">
							<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
						</div>
						<div class="col-6">
							<img src="<?php echo URL?>login/img" class="col-sm-6 img-thumbnail" />
						</div>
					</div>
					<div class="form_msg d-none">تم حذف النسخة الاحتياطية بنجاح!</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger mb-3"><i class="bi bi-trash"></i> حذف النسخة الاحتياطية</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal restore backup -->
<div id="restore" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="restore_title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<form class="row g-3 " id="restore_form" method="post" action="<?php echo URL?>backup/get_backup" data-model="del_back" data-type="restore" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="restore_title"><i class="bi bi-database"></i> إسترجاع نسخة احتياطية</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="container"></div>
				<div class="modal-body" style="">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" class="" name="file_name" :value="file_name" />
					<div class="row">
						<div class="col-sm mb-3">
							<h6 class="text-danger">هل انت متأكد من استرجاع هذه النسخة الاحتياطية {{file_name}} ؟</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-sm mb-3">
							<label for="psw" class="form-label">ادخل كلمة المرور الخاصة بك ورمز التحقق</label>
							<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
							<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
						</div>		
					</div>
					<div class="row">
						<div class="col-6">
							<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
						</div>
						<div class="col-6">
							<img src="<?php echo URL?>login/img" class="col-sm-6 img-thumbnail" />
						</div>
					</div>
					<div class="form_msg d-none">تم استرجاع البيانات بنجاح!</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning mb-3"><i class="bi bi-restore"></i> إسترجاع البيانات</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal upload backup -->
<div id="upload_backup" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="upload_backup_title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<form class="row g-3 model_form" id="upload_backup_form" method="post" action="<?php echo URL?>backup/upload_backup" data-model="upload_backup" data-type="upload" enctype="multipart/form-data" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="upload_backup_title"><i class="bi bi-download"></i> رفع ملف نسخة احتياطية</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="container"></div>
				<div class="modal-body" style="">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<div class="row">
						<div class="col-sm mb-3">
							<label for="file-upload" class="form-label">اختار ملف النسخة التى تريد استرجاعها</label>
							<input type="file" name="new_backup_file" class="form-control-small file-upload form-control-file" data-id="new_pro_image" accept="*">
							<div class="d-none err_notification" id="valid_new_staff_address">اختار الملف من فضلك</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm mb-3">
							<h6 class="text-danger">تأكد من ان النسخة الاحتياطية التي سترفعها خالية من اي اخطاء</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-sm mb-3">
							<label for="psw" class="form-label">ادخل كلمة المرور الخاصة بك ورمز التحقق</label>
							<input type="password" name="psw" class="form-control" id="psw" placeholder="كلمة المرور" required>
							<div class="invalid-feedback">من فضلك ادخل كلمة المرور!</div>
						</div>		
					</div>
					<div class="row">
						<div class="col-6">
							<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
						</div>
						<div class="col-6">
							<img src="<?php echo URL?>login/img" class="col-sm-6 img-thumbnail" />
						</div>
					</div>
					<div class="form_msg d-none">تم حفظ الملف</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning mb-3"><i class="bi bi-restore"></i> إسترجاع البيانات</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	var js_backup_list = <?php echo json_encode($this->backup_list); ?>;
</script>