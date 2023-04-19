<div class="pagetitle">
	<!-- Page Title -->
	<h1>المناطق</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">المناطق</li>
		</ol>
	</nav>
</div>
<!-- Search Section Begin -->
<section class="section" id="info_area">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<h5 class="card-title">
					<button v-if="vm_page_permission.h_access('area','new_spec')" type="button" class="btn btn-success mb-3 mx-2" data-bs-toggle="modal" data-bs-target="#new_spec">إضافة منطقة <i class="bi bi-plus-circle"></i></button>
				</h5>
				<div class="card-body table-responsive pt-0">
					<table class="table table-bordered border-secondary table-striped table-hover table-head-fixed text-right">
						<thead>
							<tr>
								<th>الرقم</th>
								<th>الإسم</th>
								<th>المدينة</th>
								<th>عدد الطلبات</th>
								<th colspan="2">الاجراء</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(x ,index) in TYPES">
								<td>{{index +1}}</td>
								<td>{{x.NAME}}</td>
								<td>{{x.CITY}}</td>
								<td>{{x.STU}}</td>
								<td>
									<button if="vm_page_permission.h_access('area','upd_spec')" v-on:click.prevent="update_type(index)" type="button" data-bs-toggle="modal" data-bs-target="#upd_spec" class="btn rounded btn-primary btn-sm" > تحديث</button>
									<i v-else="" class="bi bi-file-lock2"></i>
								</td>
								<td>
									<button v-if="vm_page_permission.h_access('area','del_spec') && x.STU == 0 " v-on:click.prevent="update_type(index)" data-bs-toggle="modal" data-bs-target="#del_spec"  class='btn rounded btn-sm btn-danger'>حذف</button>
									<i v-else="" class="bi bi-file-lock2"></i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal For add new Type -->
<div id="new_spec" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="new_spec_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="row g-3 model_form" id="new_spec_form" method="post" action="<?php echo URL?>area/new_spec" data-model="new_spec" data-type="new_spec" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="new_co_title"><i class="fa fa-plus"></i> إضافة منطقة</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<div class="col-auto">
						<label for="new_name" class="">اسم المنطقة</label>
						<input type="text" class="form-control" name="new_name" id="new_name" placeholder=" ادخل اسم المنطقة" required />
						<div class="d-none err_notification" id="valid_new_name">this field required</div>
					</div>
					<div class="col-auto">
						<label for="new_name" class="">اسم المدينة</label>
						<input type="text" class="form-control" name="new_city" id="new_city" placeholder=" ادخل اسم المنطقة" required />
						<div class="d-none err_notification" id="valid_new_city">this field required</div>
					</div>
					<div class="form_msg d-none">تم حفط المنطقة</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="fa fa-save"></i> حفط المنطقة</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="fa fa-times"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal For update TYPE -->
<div id="upd_spec" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="upd_spec_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="row g-3 model_form" id="upd_spec_form" method="post" action="<?php echo URL?>area/upd_spec" data-model="upd_spec" data-type="upd_spec">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="upd_spec_title"><i class="fa fa-edit"></i> تحديث المنطقة</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" class="" name="id" id="upd_id" :value="upd_type.ID" />
					<div class="col-auto">
						<label for="upd_name" class="">اسم المنطقة</label>
						<input type="text" class="form-control" name="upd_name" id="upd_name" :value="upd_type.NAME" placeholder=" ادخل اسم المنطقة بيانات" required />
						<div class="d-none err_notification" id="valid_upd_name">this field required</div>
					</div>
					<div class="col-auto">
						<label for="upd_name" class="">المدينة</label>
						<input type="text" class="form-control" name="upd_city" id="upd_city" :value="upd_type.CITY" placeholder=" ادخل اسم المنطقة بيانات" required />
						<div class="d-none err_notification" id="valid_upd_city">this field required</div>
					</div>
					<div class="form_msg d-none">تم تحديث المنطقة</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="fa fa-edit"></i> تحديث المنطقة</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="fa fa-times"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal For Delete Type -->
<div id="del_spec" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="del_spec_title" aria-hidden="true">
	<div class="modal-dialog text-right" role="document">
		<form class="row g-3 model_form" id="del_spec_form" method="post" action="<?php echo URL?>area/del_spec" data-model="del_spec" data-type="del_spec">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="del_spec_title"><i class="bi bi-pen"></i> مسح منطقة</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle-fill"></i></button>
				</div>
				<div class="container"></div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" name="upd_id" :value="upd_type.ID" />
					<div class="row">
						<h6>هل انت متأكد من مسح المنطقة: {{upd_type.NAME}} ؟</h6>
					</div>
					<div class="form_msg d-none">تم مسح المنطقة</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger mb-3"><i class="bi bi-pen"></i> مسح المنطقة</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> إلغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	var js_types 	= <?php echo json_encode($this->types); ?>;
	
</script>