<div id="info_area">
	<!-- Search Section Begin -->
	<section class="section">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body table-responsive pt-4">
						<form class="filter-form" id="Staff_search" v-on:submit.prevent="onSubmitSearch" method="POST" action="<?php echo URL?>dashboard/">
							<input type="hidden" name="csrf" id="csrf" class="hid_info" value="<?php echo lib::get_CSRF(); ?>" />
							<input type="hidden" name="current_page" id="current_page" class="hid_info" :value="current_page" />
							<div class="row">
								<div class="col-sm mb-3">
									<select name="city"  class="form-control">
										<option value="0">المنطقة</option>
										<option v-for="(x ,index) in aarea" :value="x.ID">{{x.NAME}} - {{x.CITY}}</option>
									</select> 
								</div>
								<div class="col-sm mb-3">
									<select name="new_spec"  class="form-control">
										<option value="0">نوع الطلب</option>
										<option v-for="(x ,index) in specialist" :value="x.ID">{{x.NAME}}</option>
									</select>
								</div>
								<div class="col-sm mb-3">
									<button type="submit" class="btn btn-block btn-primary w-100"> ابحث <i class="bi bi-search"></i></button>
								</div>
								<div class="col-sm mb-3">
									<button type="button" class="btn btn-success mb-3 mx-2" data-bs-toggle="modal" data-bs-target="#new_req">إضافة طلب خدمة <i class="bi bi-plus-circle"></i></button>
								</div>
							</div>
							<div class="row">
								<div class="col-sm mb-3">
									<input type="checkbox" name="all_data" id="all_data" value="1" v-on:change="all_data()" /> عرض كل الطلبات
								</div>
							</div>
						</form>
						<!-- Search Section End -->
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section profile">
		<div class="row">
			<div class="col-xl-3" v-for="(x ,index) in staff">
				<a target="_blank" :href="'<?php echo URL?>dashboard/index/'+x.ID">
				<div class="card">
					<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
						<h6>رقم الطلب: {{x.ID}}</h6>
						<h6>{{x.PHONE}}</h6>
						<h6>{{x.DESCR.substr(1, 50)}}</h6>
						<h6>{{aarea[x.CITY].NAME}}</h6>
						<h6>{{specialist[x.SPEC].NAME}}</h6>
						<!--h3 v-for="(item ,it_index) in items" >{{other_item(x.OTH_DATA,item.ID)}}</h3-->
					</div>
				</div>
				</a>
			</div>
		</div>
		
		<!-- pagination -->
		<nav v-if="page_no > 1" aria-label="Page navigation example">
			<ul class="pagination justify-content-center">
				<li v-if="current_page != 1" class="page-item">
					<a class="page-link" v-on:click="prev_page()" href="#" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>
				<li class="page-item" v-for="index in page_no" :key="index">
					<a class="" :class="(index==current_page)?'page-link bg-secondary':'page-link bg-light'"  v-on:click="set_page(index)" href="#">{{index}}</a>
				</li>
				<li class="page-item" v-if="current_page != page_no">
					<a class="page-link" v-on:click="next_page()" href="#" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>
			</ul>
		</nav>
		<!--End Pagination -->
	</section>
</div>
<!-- Modal For add new Type -->
<div id="new_req" class="modal fade modal_with_form" tabindex="-1" aria-labelledby="new_req_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="row g-3 model_form" id="new_req_form" method="post" action="<?php echo URL?>dashboard/new_req" data-model="new_req" data-type="new_req" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="new_co_title"><i class="fa fa-plus"></i> إضافة طلب</h5>
					<button type="button" class="btn-close btn bg-white p-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i></button>
				</div>
				<div class="modal-body">
					<input type="hidden" class="hid_info" name="csrf" value="<?php echo session::get('csrf'); ?>" />
					<!--div class="col-auto">
						<label for="new_name" class="">الاسم</label>
						<input type="text" class="form-control" name="new_name" id="new_name" placeholder=" ادخل اسم"  />
						<div class="d-none err_notification" id="valid_new_name">this field required</div>
					</div-->
					<div class="col-auto">
						<label for="new_phone" class="">الهاتف </label>
						<input type="phone" class="form-control" name="new_phone" id="new_phone" placeholder=" ادخل الهاتف" required />
						<div class="d-none err_notification" id="valid_new_name">this field required</div>
					</div>
					<!--div class="col-auto">
						<label for="new_email" class="">البريد الالكتروني</label>
						<input type="email" class="form-control" name="new_email" id="new_email" placeholder=" ادخل الايميل" />
						<div class="d-none err_notification" id="valid_new_email">this field required</div>
					</div-->
					<div class="col-auto">
						<label for="new_city" class="">الحي/ المنطقة</label>
						<select name="new_city"  class="form-control" required>
							<option value="">الحي/ المنطقة</option>
							<option v-for="(x ,index) in aarea" :value="x.ID">{{x.NAME}}</option>
						</select>
						<div class="d-none err_notification" id="valid_new_email">this field required</div>
					</div>
					<div class="col-sm mb-3">
						<label for="new_spec" class="">المجال</label>
						<select name="new_spec"  class="form-control" required>
							<option value="">التخصص</option>
							<option v-for="(x ,index) in specialist" :value="x.ID">{{x.NAME}}</option>
						</select>
						<div class="d-none err_notification" id="valid_new_spec">this field required</div>
					</div>
					<div class="col-auto">
						<label for="new_desc" class="">وصف الطلب</label>
						<textarea class="form-control" name="new_desc" id="new_desc" placeholder=" ادخل الوصف" ></textarea>
						<div class="d-none err_notification" id="valid_new_desc">this field required</div>
					</div>
					<div class="col-auto">
						<div class="row">
							<div class="col-6">
								<input type="txt" class="form-control" name="captcha" placeholder="رمز التحقق" required autocomplete="off" />
							</div>
							<div class="col-6">
								<img src="<?php echo URL?>login/img" class="col-sm-8 img-thumbnail" />
							</div>
						</div>
						<div class="d-none err_notification" id="valid_captcha">this field required</div>
					</div>
					<div class="row">
						<div class="col-12">
							<input type="checkbox" class="" id="accept" name="accept" placeholder="أوافق على الشروط والاحكام" value="1" required />
							أوافق على 
							<a href="<?php echo URL?>dashboard/terms" target="_blank"> الشروط والاحكام</a>
							<div class="err_notification " id="valid_accept">راجع مدخلات هذا الحقل</div>
						</div>
					</div>
					<div class="form_msg d-none">تم حفط الطلب</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-3"><i class="fa fa-save"></i> حفط الطلب</button>
					<button type="button" class="btn btn-secondary mb-3" data-bs-dismiss="modal"><i class="fa fa-times"></i> الغاء</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	var js_details		=  {'FILES':[]};
	var js_specialist 	= <?php echo json_encode($this->specialist); ?>;
	var js_area 		= <?php echo json_encode($this->area); ?>;
	
</script>
