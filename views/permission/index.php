<div class="pagetitle">
	<!-- Page Title -->
	<h1>الصلاحيات</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">مجموعات الصلاحيات</li>
		</ol>
	</nav>
</div>

<!-- permission -->
<section class="section vue_area_div" id="staff_settings">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body table-responsive pt-3">
					<input type="hidden" name="csrf" id="csrf" class="hid_info" value="<?php echo lib::get_CSRF(); ?>" />
					<div class="property-comparison-section">
						<div class="container">
							<div class="row">
								<div class="mb-3">
									<a target="_blank" href="<?php echo URL?>permission/new_group" class="btn btn-success">إضافة مجموعة جديدة <i class="bi bi-plus-circle"></i></a>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 p-0">
									<div class="table-responsive">
										<table class="table table table-bordered border-secondary table-striped table-hover table-head-fixed text-right">
											<thead>
												<tr>
													<th>الرقم</th>
													<th>اسم المجموعة</th>
													<th>تعريف الصلاحية</th>
													<th>عدد المستخدمين</th>
													<th colspan="2">الصفحة الافتراضية</th>
													<th colspan="2">الأجراء</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(x ,index) in group">
													<td>{{index + 1}}</td>
													<td>{{x.NAME}}</td>
													<td>{{x.DESCR}}</td>
													<td>{{x.STAFF}}</td>
													<td>{{x.DEF_CLS}}/{{x.DEF_PG}}</td>
													<td>{{x.DEF_DESC}}</td>
													<td><a target="_blank" :href="x.LINK" class="btn btn-sm btn-primary rounded">تحديث</a></td>
													<td v-if="vm_page_permission.h_access('permission','del_group')"><button class="btn btn-sm btn-danger rounded" v-if="x.ID != 1 && x.STAFF == 0" @click="del(index)">حذف</button></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	
</div>
<script>
	var js_group 		= <?php echo json_encode($this->group); ?>;
	var js_pages 		= <?php echo json_encode($this->pages); ?>;
</script>