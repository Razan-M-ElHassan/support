<div class="pagetitle">
	<!-- Page Title -->
	<h1>المستخدمين</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo URL?>dashboard">لوحة التحكم</a></li>
			<li class="breadcrumb-item active">تفاصيل المستخدم {{upd_staff.NAME}}</li>
		</ol>
	</nav>
</div>
<section class="section dashboard" id="info_area">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body pt-4">
					<div class="d-flex justify-content-center">
						<img :src="upd_staff.IMG" class="img-thumbnail rounded-circle" width="200px" height="200px" alt="100x100"/>
					</div>
					<div class="card-title">
						بيانات المستخدم
					</div>
					<table class="table table-bordered border-secondary table-striped table-hover">
						<thead>
							<tr>
								<th>الاسم</th>
								<th>البيان</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>رقم المستخدم الداخلي</td>
								<td>{{upd_staff.ID}}</td>
							</tr>
							<tr>
								<td>الاسم</td>
								<td>{{upd_staff.NAME}}</td>
							</tr>
							<tr>
								<td>الهاتف</td>
								<td>{{upd_staff.PHONE}}</td>
							</tr>
							<tr>
								<td>البريد الإلكتروني</td>
								<td>{{upd_staff.EMAIL}}</td>
							</tr>
							<tr>
								<td>التخصص</td>
								<td>{{specialist[upd_staff.SPEC].NAME}}</td>
							</tr>
							<tr>
								<td>المدينة</td>
								<td>{{upd_staff.CITY}}</td>
							</tr>
							<tr v-for="(item ,it_index) in items" v-if="other_item(upd_staff.OTH_DATA,item.ID) != ''" >
								<td>{{item.NAME}}</td>
								<td>{{other_item(upd_staff.OTH_DATA,item.ID)}}</td>
							</tr>
						</body>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>


<script>
	var js_permission	= <?php echo json_encode($this->permissions); ?>;
	var js_specialist	= <?php echo json_encode($this->specialist); ?>;
	var js_items		= <?php echo json_encode($this->items); ?>;
	var js_countries	= <?php echo json_encode(lib::$countries); ?>;
	var js_details 		= <?php echo json_encode($this->details); ?>;
	
</script>
