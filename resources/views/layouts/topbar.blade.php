	<div class="header ">
		<!-- START MOBILE SIDEBAR TOGGLE -->
		<a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
		</a>
		<!-- END MOBILE SIDEBAR TOGGLE -->
		<div class="notification-container">
			<div class="brand inline">
				<div class="m-l-50">
					<a href="<?=url('/');?>"><h4 class="m-l-20"><img src="<?=url('/')?>/public/assets/img/logo.png" alt=""></h4></a>
				</div> 
			</div>
			<!-- START NOTIFICATION LIST -->
			
			<!-- END NOTIFICATIONS LIST -->
		</div>
		<a href='{{url("/")}}'><i style="font-size: 30px;color: #ff3f00;" class="pg-home"></i> </a>
		<div class="user-container d-flex align-items-center">
			<!-- START User Info-->
			<div class="pull-left d-lg-block">
				<!-- <input type="text" name="search" placeholder="Search for a task" id="search">			 	 -->
				<!-- <ul class="d-lg-inline-block d-none notification-list no-margin d-lg-inline-block b-grey no-style p-l-30 p-r-20 search-btn" style="margin-right:20px !important">
				 <li>
					 	<a href="#"><img src="<?=url("/");?>/public/assets/img/dashboard/icon-plus.png" alt=""></a>
				 </li>
					
				</ul> -->
			</div>

			<div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
				<span class="semi-bold username">{{ Auth::user()->name }}</span>
			</div>
			<div class="dropdown pull-right d-lg-block d-none">
				<button class="nav-ellip header-icon pg pg-alt_menu  btn-link m-l-10 sm-no-margin d-inline-block profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				
				</button>
				<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
					<a href='{{url("/")}}/meeting' class="dropdown-item"><i class="pg-settings_small"></i> Book a Meeting</a>

					<a href='{{url("/")}}/settings/custom' class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>


					<a href="<?=url('/')?>/logout" class="clearfix bg-master-lighter dropdown-item">
						<span class="pull-left">Logout</span>
						<span class="pull-right"><i class="pg-power"></i></span>
					</a>
				</div>
			</div>
			<!-- END User Info-->
			<!-- <a href="#" class="nav-ellip header-icon pg pg-alt_menu btn-link m-l-10 sm-no-margin d-inline-block" data-toggle="quickview" data-toggle-element="#quickview"></a> -->
		</div>
	</div>
	

