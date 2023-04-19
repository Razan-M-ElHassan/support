<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
	<div class="d-flex align-items-center justify-content-between">
		<a href="<?php echo URL?>" class="logo d-flex align-items-center">
			<img src="<?php echo URL."public/IMG/".session::get("LOGO");?>" alt="" class="rounded">
			<span class="d-none d-lg-block"><?php echo session::get("TITLE");?></span>
		</a>
		<i class="bi bi-list toggle-sidebar-btn"></i>
	</div><!-- End Logo -->
<?php 
	if(session::get("user_id"))
	{
?>
	<nav class="header-nav ms-auto">
		<ul class="d-flex align-items-center" id="profile_noti_area">
			<li class="nav-item dropdown pe-3 notification_li">
				<a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
					<i class="bi bi-bell"></i>
					<span class="badge bg-primary badge-number">{{new_noti}}</span>
				</a><!-- End Notification Icon -->
				<ul class="dropdown-menu dropdown-menu-arrow notifications noti" >
					<li class="dropdown-header">
						لديك {{new_noti}} تنبيه جديد
						<button v-if="new_noti != 0" v-on:click="all_read()" class="badge rounded-pill bg-primary p-2 ms-2">مقروءة</button>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li :class="(not.STATUS === null )?'notification-item decor':'notification-item'" v-if="notification.length" v-for="(not,id) in notification " >
						<!--i class="bi bi-person-circle text-primary"></i-->
						<div v-on:mouseover="read_noti(not.ID)">
							<a :href="'<?php echo URL;?>'+not.URL" >
								<p>{{not.TITLE}}</p>
							</a>
						</div>
						<hr class="dropdown-divider">
					</li>
				</ul><!-- End Notification Dropdown Items -->
			</li><!-- End Notification Nav -->
			<li class="nav-item dropdown pe-3">
				<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
					<img src="<?php echo URL."public/IMG/user/".session::get('user_img') ?>" alt="Profile" class="rounded-circle">
					<span class="d-none d-md-block dropdown-toggle ps-2"><?php echo session::get('user_name');?></span>
				</a><!-- End Profile Iamge Icon -->
				<ul class="dropdown-menu dropdown-menu-arrow profile dropdown-menu-start ">
					<li class="dropdown-header">
						<h6><?php echo session::get('user_name');?> </h6>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li>
						<a class="dropdown-item d-flex align-items-center" href="<?php echo URL?>profile">
							<i class="bi bi-person"></i>
							<span>البروفايل</span>
						</a>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li>
						<a class="dropdown-item d-flex align-items-center" href="<?php echo URL?>login/logout">
							<i class="bi bi-box-arrow-right"></i>
							<span>تسجيل خروج</span>
						</a>
					</li>
				</ul><!-- End Profile Dropdown Items -->
			</li><!-- End Profile Nav -->
		</ul>
	</nav><!-- End Icons Navigation -->
<?php
	}
?>

</header><!-- End Header -->
	 
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar area_view">
    <ul class="sidebar-nav" id="sidebar-nav">
		<li class="nav-item">
			<!--a class="nav-link collapsed" href="<?php echo URL?>dashboard"-->
				<i class="bi bi-speedometer"></i>
				<span>لوحة التحكم</span>
			<!--/a-->
		</li>
		<li class="nav-item" v-if="h_access('configuration')">
			<a class="nav-link collapsed" data-bs-target="#conf_tables-nav" data-bs-toggle="collapse" href="#">
				<i class="bi bi-gear"></i> <span> الإعدادات </span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="conf_tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
				<li>
					<a v-if="h_access('configuration')" href="<?php echo URL?>configuration">
						<i class="bi bi-gear"></i>
						<span>الإعدادات العامة</span>
					</a>
				</li>
				<li class="nav-item" v-if="h_access('backup')">
					<a class="nav-content collapsed" href="<?php echo URL?>backup">
						<i class="bi bi-database"></i>
						<span>النسخ الاحتياطي</span>
					</a>
				</li>
				<li class="nav-item" v-if="h_access('permission')">
					<a class="nav-content collapsed"  href="<?php echo URL?>permission">
						<i class="bi bi-lock"></i>
						<span>الصلاحيات</span>
					</a>
				</li>
				<li class="nav-item" v-if="h_access('specialist')">
					<a class="nav-content collapsed" href="<?php echo URL?>specialist">
						<i class="bi bi-list"></i>
						<span>التخصصات</span>
					</a>
				</li>
				<li class="nav-item" v-if="h_access('area')">
					<a class="nav-content collapsed" href="<?php echo URL?>area">
						<i class="bi bi-list"></i>
						<span>المناطق</span>
					</a>
				</li>
			</ul>
		</li><!-- End Tables Nav -->
		<li class="nav-item" v-if="h_access('staff')">
			<a class="nav-link collapsed" href="<?php echo URL?>staff">
				<i class="bi bi-people"></i>
				<span>المستخدمين</span>
			</a>
		</li>
		<li class="nav-item" v-if="h_access('staff')">
			<a class="nav-link collapsed" href="<?php echo URL?>requests">
				<i class="bi bi-people"></i>
				<span>الطلبات</span>
			</a>
		</li>
		<li class="nav-item" v-if="h_access('reports')">
			<a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
				<i class="bi bi-journals"></i> <span> التقارير </span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
				<li>
					<a href="<?php echo URL?>reports/">
						<i class="bi bi-bag"></i><span>تقرير 1</span>
					</a>
				</li>
				<li>
					<a v-if="h_access('reports','supervisor')"  href="<?php echo URL?>reports/supervisor">
						<i class="bi bi-calendar3"></i><span>تقرير 2</span>
					</a>
				</li>
				<li>
					<a v-if="h_access('reports','school')" href="<?php echo URL?>reports/school">
						<i class="bi bi-building"></i><span>تقرير 3</span>
					</a>
				</li>
				<li>
					<a v-if="h_access('reports','staff')" href="<?php echo URL?>reports/staff">
						<i class="bi bi-people"></i><span>تقرير 4</span>
					</a>
				</li>
			</ul>
		</li><!-- End Tables Nav -->
    </ul>
</aside><!-- End Sidebar-->

<main id="main" class="main vue_area_div area_view">

