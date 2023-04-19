<section class="section dashboard" id="info_area">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body pt-4">
					<div class="card-title">
						
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
								<td>المنطقة</td>
								<td>{{aarea[upd_staff.CITY].NAME}}</td>
							</tr>
							<tr>
								<td>التخصص</td>
								<td>{{specialist[upd_staff.SPEC].NAME}}</td>
							</tr>
							<tr>
								<td>الوصف</td>
								<td>{{upd_staff.DESCR}}</td>
							</tr>
							<tr>
								<td>وقت الطلب</td>
								<td>{{upd_staff.REQ_TIME}}</td>
							</tr>
							<tr>
								<td>وقت النشر</td>
								<td>{{upd_staff.AC_TIME}}</td>
							</tr>
							
						</body>
					</table>
					<div class="row">
						<div class="col-sm col-lg-6">
							<div v-if="upd_staff.FILES.length">
								<div class="row " v-if="image_files.length">
									<p>الصور</p>
									<div class="card col-lg-6" v-for="(x ,index) in image_files">
										<img :src="x.URL" class="card-img-top img-thumbnail" :alt="x.NAME">
									</div>
								</div>
								<div class="row" v-if="other_files.length">
									<p>الملفات</p>
									<ol class="list-group list-group-flush" >
										<li v-for="(x ,index) in other_files" class="list-group-item d-flex justify-content-between align-items-start">
											<div class="ms-2 me-auto">
												<span class="fw-bold">الملف - </span> <a :href="x.URL" target="_blank">{{x.NAME}}</a>
											</div>
										</li>
									</ol><!-- End with custom content -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<script>
	var js_details 		= <?php echo json_encode($this->details); ?>;
	var js_specialist 	= <?php echo json_encode($this->specialist); ?>;
	var js_area 		= <?php echo json_encode($this->area); ?>;
	
</script>
