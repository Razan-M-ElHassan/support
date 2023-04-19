<div class="pagetitle">
	<h1>الطلبات</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">الطلبات</li>
		</ol>
	</nav>
</div><!-- End Page Title -->
<!-- Search Section Begin -->
<section class="section" id="info_area">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body table-responsive pt-4">
					<form class="filter-form" id="request_search" v-on:submit.prevent="onSubmitSearch" method="POST" action="<?php echo URL?>requests/">
						<input type="hidden" name="csrf" id="csrf" class="hid_info" value="<?php echo lib::get_CSRF(); ?>" />
						<input type="hidden" name="current_page" id="current_page" class="hid_info" :value="current_page" />
						<div class="row">
							<div class="col-sm mb-3">
									<select name="city"  class="form-control">
										<option value="0">المنطقة</option>
										<option v-for="(x ,index) in aarea" :value="x.ID">{{x.NAME}}</option>
									</select> 
								</div>
								<div class="col-sm mb-3">
									<select name="new_req"  class="form-control">
										<option value="0">نوع الطلب</option>
										<option v-for="(x ,index) in specialist" :value="x.ID">{{x.NAME}}</option>
									</select>
								</div>
							<div class="col-sm mb-3">
								<input type="checkbox" name="all_data" id="all_data" value="1" v-on:change="all_data()" /> عرض كل الطلبات
							</div>
							<div class="col-sm mb-3">
								<button type="submit" class="btn btn-block btn-primary w-100"> ابحث <i class="bi bi-search"></i></button>
							</div>
						</div>
					</form>
					<!-- Search Section End -->

					<!--request List-->
					<table class="table table-bordered border-secondary table-striped table-hover table-head-fixed text-right">
						<thead>
							<tr>
								<th>رقم الطلب</th>
								<th>الاسم</th>
								<th>رقم الهاتف</th>
								<th>الايميل</th>
								<th>النوع</th>
								<th>المنطقة</th>
								<th>وقت الطلب</th>
								<th colspan="3">الاجراء</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(x ,index) in request">
								<td>{{x.ID}}</td>
								<td>{{x.NAME}}</td>
								<td>{{x.PHONE}}</td>
								<td>{{x.EMAIL}}</td>
								<td>{{specialist[x.SPEC].NAME}}</td>
								<td>{{aarea[x.CITY].NAME}}</td>
								<td>{{x.REQ_TIME}}</td>
								<td><button v-on:click.prevent="update_request(index)" data-bs-toggle="modal" data-bs-target="#details" class='btn rounded btn-sm btn-success '>التفاصيل</button></td>
								<td>
									<button v-if="x.ACA == 0" v-on:click.prevent="active(index)" class='btn rounded btn-sm btn-success'>قبول الطلب</button>
									<button v-else-if="x.DON == 0" v-on:click.prevent="done(index)" class='btn rounded btn-sm btn-success '>إكتمال الطلب</button>
								</td>
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

<!-- Modal For details -->
<div id="details" class="modal fade" tabindex="-1" aria-labelledby="details_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="details_title">التفاصيل</h5>
				<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered border-secondary table-striped table-hover">
					<thead>
						<tr>
							<th>الاسم</th>
							<th>البيان</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>الاسم</td>
							<td>{{upd_request.NAME}}</td>
						</tr>
						<tr>
							<td>الهاتف</td>
							<td>{{upd_request.PHONE}}</td>
						</tr>
						<tr>
							<td>البريد الإلكتروني</td>
							<td>{{upd_request.EMAIL}}</td>
						</tr>
						<tr>
							<td>المنطقة</td>
							<td>{{aarea[upd_request.CITY].NAME}}</td>
						</tr>
						<tr>
							<td>التخصص</td>
							<td>{{specialist[upd_request.SPEC].NAME}}</td>
						</tr>
						<tr>
							<td>الوصف</td>
							<td>{{upd_request.DESCR}}</td>
						</tr>
						<tr>
							<td>وقت الطلب</td>
							<td>{{upd_request.REQ_TIME}}</td>
						</tr>
						<tr>
							<td>وقت النشر</td>
							<td>{{upd_request.AC_TIME}}</td>
						</tr>
						<tr v-if="upd_request.DON == 1">
							<td>وقت الاقفال</td>
							<td>{{upd_request.DON_TIME}}</td>
						</tr>
					</body>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal For update co ->
<div id="upd_stat" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="upd_stat_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="row g-3 model_form" id="upd_stat_form" method="post" action="<?php echo URL?>request/upd_stat" data-model="upd_stat" data-type="upd_stat" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="upd_stat_title"><i class="fa fa-edit"></i> تحديث حالة الطلب</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<input type="hidden" class="" name="upd_id" id="upd_id" :value="upd_request.ID" />
					<div class="col-auto mb-3">
						<label for="new_stat">الحالة</label>
						<select name="new_stat" id="new_stat" class="form-control">
							<option v-for="(x,index) in STATUS" :value="index" :selected="index == upd_request.STAT" >{{x}}</option>
						</select>
						<div class="err_notification " id="valid_new_stat">Error In this Filed</div>
					</div>
					<div class="form_msg d-none">تم تحديث الحالة</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="fa fa-edit"></i> تحديث الحالة</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="fa fa-times"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div-->

<script>
	var js_details		=  {'CITY':1,'SPEC':1};
	var js_specialist 	= <?php echo json_encode($this->specialist); ?>;
	var js_area 		= <?php echo json_encode($this->area); ?>;
	
</script>
