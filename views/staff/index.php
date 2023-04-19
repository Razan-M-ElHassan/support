<div class="pagetitle">
	<!-- Page Title -->
	<h1>الطلاب</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">الطلاب</li>
		</ol>
	</nav>
</div>

<!-- Search Section Begin -->
<section class="section" id="info_area">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body table-responsive pt-4">
					<form class="filter-form" id="Staff_search" v-on:submit.prevent="onSubmitSearch" method="POST" action="<?php echo URL?>staff/">
						<input type="hidden" name="csrf" id="csrf" class="hid_info" value="<?php echo lib::get_CSRF(); ?>" />
						<input type="hidden" name="current_page" id="current_page" class="hid_info" :value="current_page" />
						<div class="row">
							<div class="col-sm mb-3">
								<input name="name" class="form-control" placeholder="الاسم" />
							</div>	
							<div class="col-sm mb-3">
								<input name="email" class="form-control" placeholder="البريد الالكتروني" />
							</div>	
							<div class="col-sm mb-3">
								<input name="phone" class="form-control" placeholder="الهاتف" /> 
							</div>	
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<input type="checkbox" name="all_data" id="all_data" value="1" v-on:change="all_data()" /> عرض كل الطلاب
							</div>
							<div class="col-sm mb-3">
								<button type="submit" class="btn btn-block btn-primary w-100"> ابحث <i class="bi bi-search"></i></button>
							</div>
							<div class="col-sm mb-3" v-if="vm_page_permission.h_access('staff','msg_staff')">
								<button type="button" class="btn btn-block btn-primary w-100" v-on:click.prevent="message()"> ارسال SMS <i class="bi bi-send"></i></button>
							</div>
							<div class="col-sm mb-3" v-if="vm_page_permission.h_access('staff','new_staff')">
								<button type="button" class="btn btn-block btn-success w-100" data-bs-toggle="modal" data-bs-target="#new_staff">
									اضافة طالب <i class="bi bi-plus-circle"></i>
								</button>
							</div>
						</div>
					</form>
					<!-- Search Section End -->

					<!--Staff List-->
					<table class="table table-bordered border-secondary table-striped table-hover table-head-fixed text-right">
						<thead>
							<tr>
								<th><input type="checkbox" id='msgs' v-on:change="change_msg()" /></th>
								<th>الصورة</th>
								<th>الإسم</th>
								<th>رقم الهاتف</th>
								<th>البريد الالكتروني</th>
								<th>التخصص</th>
								<th>المدينة</th>
								<th colspan="2">الاجراء</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(x ,index) in staff">
								<td><input type="checkbox" class="msgs" v-bind:data-id="x.ID" /></td>
								<td><img v-bind:src="x.IMG" class="img-thumbnail rounded-circle" width="50px" height="50px" alt="100x100"/></td>
								<td><a target="_blank" :href="'<?php echo URL?>staff/index/'+x.ID"> {{x.NAME}} </a></td>
								<td>{{x.PHONE}}</td>
								<td>{{x.EMAIL}}</td>
								<td><template v-if="x.SPEC != null">{{specialist[x.SPEC].NAME}}</template></td>
								<td>{{x.CITY}}</td>
								<td>
									<button v-if="vm_page_permission.h_access('staff','upd_staff')" v-on:click.prevent="update_staff(index)" type="button" data-bs-toggle="modal" data-bs-target="#upd_staff" class="btn rounded btn-primary btn-sm" > تحديث </button>
									<i v-else="" class="bi bi-file-lock2"></i>
								</td>
								<td v-if="vm_page_permission.h_access('staff','active')">
									<button v-if="x.ACTIVE == 1" v-on:click.prevent="active(index)" class='btn rounded btn-sm btn-warning'>تجميد</button>
									<button v-else="" v-on:click.prevent="active(index)" class='btn rounded btn-sm btn-success '>تنشيط</button>
								</td>
								<td v-else-if="x.ADMIN != 1"><i class="bi bi-file-lock2"></i></td>
							</tr>
						</tbody>
					</table>
					<!-- pagination -->
					<nav v-if="page_no > 1" aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							<li v-if="current_page != 1" class="page-item">
								<a class="page-link" v-on:click="prev_page()" href="#" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</a>
							</li>
							<li class="page-item" v-for="index in page_no" :key="index"><a class="" :class="(index==current_page)?'page-link bg-secondary':'page-link bg-light'"  v-on:click="set_page(index)" href="#">{{index}}</a></li>
							<li class="page-item" v-if="current_page != page_no">
								<a class="page-link" v-on:click="next_page()" href="#" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
						</ul>
					</nav>
					<!--End Pagination -->
				</div>
			</div>
		</div>
	</div>
</section>
	
<!-- Modal For add new Staff -->
<div id="new_staff" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="new_staff_title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form class="row g-3 model_form" id="new_staff_form" method="post" action="<?php echo URL?>staff/new_staff" data-model="new_staff" data-type="new" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="new_staff_title"><i class="bi bi-plus-circle"></i> إضافة مستخدم</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<div class="row">
						<div class="col-sm col-lg-6 mb-3">
							<label for="new_name" class="">الإسم</label>
							<input type="text" class="form-control" name="new_name" id="new_name" placeholder=" الاسم" required />
							<div class="err_notification" id="valid_new_name">راجع مدخلات هذا الحقل</div>
						</div>
						<div class="col-sm col-lg-6 mb-3">
							<label for="new_spec">التخصص</label>
							<select name="new_spec" v-model="CURR_NAT" class="form-control">
								<option v-for="(x,index) in specialist" :value="index" >{{x.NAME}}</option>
							</select>
							<div class="err_notification " id="valid_new_spec">راجع مدخلات هذا الحقل</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm col-lg-6 mb-3">
							<label for="new_phone">الهاتف</label>
							<input type="phone" name="new_phone" id="new_phone" class="form-control" />
							<div class="err_notification " id="valid_new_phone">راجع مدخلات هذا الحقل</div>
						</div>
						<div class="col-sm col-lg-6 mb-3">
							<label for="new_email">البريد الالكتروني</label>
							<input type="email" name="new_email" id="new_email" class="form-control" required />
							<div class="err_notification " id="valid_new_email">راجع مدخلات هذا الحقل</div>
						</div>
					</div>
					<div class="form_msg d-none">تمت إضافة المستخدم</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> إضافة مستخدم</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>
	
<!-- Modal For update Staff -->
<div id="upd_staff" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="upd_staff_title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form class="row g-3 model_form text-right" id="upd_staff_form" method="post" action="<?php echo URL?>staff/upd_staff" data-model="upd_staff" data-type="upd" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="upd_staff_title"><i class="bi bi-pen"></i> تعديل بيانات مستخدم</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" id="upd_id" name="upd_id" :value="upd_staff.ID" />
					<div class="row">
						<div class="col-sm col-lg-6 mb-3">
							<label for="upd_name" class="">الإسم</label>
							<input type="text" class="form-control" name="upd_name" id="upd_name" :value="upd_staff.NAME" placeholder=" ادخل اسم المستخدم" required />
							<div class="err_notification" id="valid_upd_name">راجع مدخلات هذا الحقل</div>
						</div>
						<div class="col-sm col-lg-6 mb-3">
							<label for="upd_spec">التخصص</label>
							<select name="upd_spec" class="form-control">
								<option v-for="(x,index) in specialist" :value="index" :selected="x.ID == upd_staff.SPEC" >{{x.NAME}}</option>
							</select>
							<div class="err_notification " id="valid_upd_spec">راجع مدخلات هذا الحقل</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm col-lg-6 mb-3">
							<label for="upd_phone">الهاتف</label>
							<input type="phone" name="upd_phone" id="upd_phone" :value="upd_staff.PHONE" class="form-control" />
							<div class="err_notification " id="valid_upd_phone">راجع مدخلات هذا الحقل</div>
						</div>
						<div class="col-sm col-lg-6 mb-3">
							<label for="upd_email">البريد الالكتروني</label>
							<input type="email" name="upd_email" id="upd_email" :value="upd_staff.EMAIL" class="form-control" />
							<div class="err_notification " id="valid_upd_email">راجع مدخلات هذا الحقل</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm col-lg-6 mb-3">
							<label for="upd_city">المدينة</label>
							<input name="upd_city" :value="upd_staff.CITY" class="form-control" />
							<div class="err_notification " id="valid_upd_city">راجع مدخلات هذا الحقل</div>
						</div>
						<div v-for="(item ,it_index) in items" class="col-sm col-lg-6 mb-3">
							<label for="upd_item">{{item.NAME}}</label>
							<input type="hidden" name="upd_item_id[]" :value="item.ID" />
							<input name="upd_item[]" :value="other_item(upd_staff.OTH_DATA,item.ID)" class="form-control" />
						</div>
					</div>
					<div class="form_msg d-none">تم تحديث بيانات المستخدم</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="bi bi-pen"></i> تحديث</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancel</button>
				</div>
			</div>
		</form>
	</div>
</div>
	
<!-- Modal For Delete Staff -->
<div id="del_staff" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="del_staff_title" aria-hidden="true">
	<div class="modal-dialog text-right" role="document">
		<form class="row g-3 model_form" id="del_staff_form" method="post" action="<?php echo URL?>staff/del_staff" data-model="del_staff" data-type="del">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="del_staff_title"><i class="bi bi-pen"></i> مسح مستخدم</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="container"></div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" name="upd_id" :value="upd_staff.ID" />
					<div class="row">
						<h4>هل انت متأكد من مسح المستخدم: {{upd_staff.NAME}} ?</h4>
					</div>
					<div class="form_msg d-none">تم مسح المستخدم</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger mb-3"><i class="bi bi-pen"></i> مسح المستخدم</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> إلغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal For MSG staff -->
<div id="msg_staff" class="modal fade" tabindex="-1" aria-labelledby="msg_staff_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="row g-3 text-right" v-on:submit.prevent="send_msg" id="msg_staff_form" method="post" action="<?php echo URL?>staff/msg_staff" data-model="upd_staff" data-type="upd">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="msg_staff_title"><i class="bi bi-send"></i> Send MSG</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i> </button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" v-for="x in msg_user" name="msg_user[]" :value="x" />
					<div class="col-sm">
						<label for="msg_comm">Message</label>
						<textarea type="text" name="msg_comm" id="msg_comm" class="form-control"></textarea>
						<div class="err_notification " id="valid_msg_comm" >راجع مدخلات هذا الحقل</div>
					</div>
					<div class="col-6">
						<input type="checkbox" name="sms_msg" class="form-controls" value="SMS" />
						<label for="sms_msg">Send SMS</label>
					</div>
					<div class="col-6">
						<input type="checkbox" name="email_msg" class="form-controls" value="EMAIL" checked />
						<label for="sms_msg">Send E-mail</label>
					</div>
					<div class="form_msg d-none">Messages Sent</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="bi -bi-send"></i> Send</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancel</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	var js_permission	= <?php echo json_encode($this->permissions); ?>;
	var js_specialist	= <?php echo json_encode($this->specialist); ?>;
	var js_items		= <?php echo json_encode($this->items); ?>;
	var js_countries	= <?php echo json_encode(lib::$countries); ?>;
	var js_details		=  {'FILES':[],'OTH_DATA':[]};
</script>
