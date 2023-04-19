<div class="pagetitle">
	<h1>البروفايل</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">الزيارات</a></li>
			<li class="breadcrumb-item active">البروفايل</li>
		</ol>
	</nav>
</div><!-- End Page Title -->

<section class="section profile vue_area_div staff_info" id="staff_info">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<!-- Modal For Staff -->
				<div class="d-flex justify-content-center ">
					<form class="g-3 p-5 mb-3" id="staff_form"  v-on:submit.prevent="onSubmitupd" method="post" action="<?php echo URL?>profile/upd_info"  enctype="multipart/form-data">
						<input type="hidden" class="hid_info" id="csrf" name="csrf" value="<?php echo session::get('csrf'); ?>" />
						<div class="row mb-3">
							<div class="col-sm">
								<img id="new_pro_image" v-bind:src="info.IMG" width="150px" height="150px" class="img-thumbnail rounded-circle mb-1" alt="..."> <br />
								<label for="new_staff_name" class="">اختار صورة الملف الشخصي</label>
								<input type="file" name="new_pro_image" class="form-control-small file-upload image_upload form-control-file" placeholder="صورة الملف الشخصي" data-id="new_pro_image" id="img" accept="image/*">
								<div class="d-none err_notification" id="valid_new_staff_address">اختار صورة من فضلك</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="new_staff_name" class="">الاسم</label>
								<input type="text" :value="info.NAME" class="form-control" name="new_staff_name" id="new_staff_name" placeholder=" Add Your Full Name" required>
								<div class="d-none err_notification" id="valid_new_staff_name">ادخل الاسم من فضلك</div>
							</div>
							<div class="col-sm col-lg-6 mb-3">
								<label for="new_staff_spec">التخصص</label>
								<select name="new_staff_spec" class="form-control" disabled >
									<option value=""></option>
									<option v-for="(x,index) in specialist" :value="index" :selected="x.ID == info.SPEC" >{{x.NAME}}</option>
								</select>
								<div class="err_notification " id="valid_new_staff_spec">راجع مدخلات هذا الحقل</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm col-lg-6 mb-3">
								<label for="new_staff_phone" class="">رقم الهاتف</label>
								<input type="text" :value="info.PHONE" class="form-control" name="new_staff_phone" id="new_staff_phone" placeholder=" add Your Phone no" >
								<div class="d-none err_notification" id="valid_new_staff_phone">ادخل رقم الهاتف من فضلك</div>
								<div class="w3-hide err_notification w3-small w3-text-red" id="duplicate_new_staff_phone">رقم الهاتف المدخل موجود فى النظام</div>
							</div>
							<div class="col-lg-6 mb-3">
								<label for="new_staff_email" class="">البريد الإلكتروني</label>
								<input id="new_staff_email" readonly type="text" v-bind:value="info.EMAIL" class="form-control" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm col-lg-6 mb-3">
								<label for="new_staff_city">المدينة</label>
								<input name="new_staff_city" :value="info.CITY" class="form-control" />
								<div class="err_notification " id="valid_new_staff_city">راجع مدخلات هذا الحقل</div>
							</div>
							<div v-for="(item ,it_index) in items" class="col-sm col-lg-6 mb-3">
								<label for="upd_item">{{item.NAME}}</label>
								<input type="hidden" name="upd_item_id[]" :value="item.ID" />
								<input name="upd_item[]" :value="other_item(item.ID)" class="form-control" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="new_file_image" class="label-control">أضف سيرتك الذاتية إن وجدت</label>
								<input name="new_file_image[]" type="file" max_size="<?php echo MAX_FILE_SIZE ;?>" class="file-upload multi_image_upload form-control-file" data-id="upd_images_area" multiple />
								<div class="d-none err_notification" id="valid_new_file_image">this field required</div>
							</div>
							<div class="row clear_form_area" id="upd_images_area"></div>
						</div>
						<div class="row">
							<div class="col-sm col-lg-12">
								<div v-if="info.FILES.length">
									<div class="card-title">
										الملفات
									</div>
									<table class="table table-bordered border-secondary table-striped table-hover">
										<thead>
											<tr>
												<th>الملف</th>
												<th>الاجراء</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(x ,index) in image_files">
												<td><img :src="x.URL" width="150px" height="150px" class="img-thumbnail rounded-circle mb-1" :alt="x.NAME"></td>
												<td>
													<button type="button" v-on:click.prevent="del_img(x.ID)" class="btn btn-warning mb-3" ><i class="bi bi-x"></i> حذف</button>
												</td>
											</tr>
											<tr v-for="(x ,index) in other_files">
												<td><a target="_blank" :href="x.URL">{{x.NAME}}</a></td>
												<td>
													<button type="button" v-on:click.prevent="del_img(x.ID)" class="btn btn-warning mb-3" ><i class="bi bi-x"></i> حذف </button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<h5>تحديث كلمة المرور</h5>
							<span class="text-danger mr-3">(اترك حقل كلمة المرور فارغاً اذا كنت لا تريد تحديثها)</span>
							<hr/>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="curr_staff_pass" class="">كلمة المرور الحالية</label>
								<input type="password" class="form-control" name="curr_staff_pass" id="curr_staff_pass" placeholder=" Add Current Password" required >
								<div class="d-none err_notification" id="valid_curr_staff_pass">هذا الحقل مطلوب</div>
							</div>
							<div class="col-sm mb-3">
								<label for="new_staff_pass" class="">كلمة المرور الجديدة</label>
								<input type="password" class="form-control" name="new_staff_pass" id="new_staff_pass" placeholder=" كلمة المرور الجديدة" >
								<div class="d-none err_notification" id="valid_new_staff_pass">ادخل كلمة المرور الجديدة من فضلك</div>
							</div>
							<div class="col-sm mb-3">
								<label for="new_staff_pass2" class="">تاكيد كلمة المرور الجديدة</label>
								<input type="password" class="form-control" name="new_staff_pass2" id="new_staff_pass2" placeholder="تاكيد كلمة المرور الجديدة " >
								<div class="d-none err_notification" id="valid_new_staff_pass2">ادخل كلمة المرور الجديد للتاكيد من فضلك</div>
							</div>
						</div>
						<div class="row" v-if="info.ID != 1">
							<div class="col-12">
								<input type="checkbox" class="" id="accept" name="accept" placeholder="أوافق على الشروط والاحكام" value="1" :checked="info.ACE == 1" />
								أوافق على 
								<a href="<?php echo URL?>dashboard/terms" target="_blank"> الشروط والاحكام</a>
								<div class="err_notification " id="valid_accept">راجع مدخلات هذا الحقل</div>
							</div>
						</div>
						<input v-else="" type="hidden" name="accept" value="1" />
						<div class="row">
							<button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> تحديث البيانات</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	var js_info 		= <?php echo $this->sys_info; ?>;
	var js_specialist	= <?php echo json_encode($this->specialist); ?>;
	var js_items		= <?php echo json_encode($this->items); ?>;
	
</script>
