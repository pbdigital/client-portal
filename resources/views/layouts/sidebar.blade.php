	@php
	$user_type = Auth::user()->user_type;
	@endphp
	<nav class="page-sidebar" data-pages="sidebar">
		<!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
		<div class="sidebar-overlay-slide from-top" id="appMenu">
			<div class="row">
				<div class="col-xs-6 no-padding">
					<a href="#" class="p-l-40"><img src="<?=url('/')?>/public/assets/img/demo/social_app.svg" alt="socail">
					</a>
				</div>
				<div class="col-xs-6 no-padding">
					<a href="#" class="p-l-10"><img src="<?=url('/')?>/public/assets/img/demo/email_app.svg" alt="socail">
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 m-t-20 no-padding">
					<a href="#" class="p-l-40"><img src="<?=url('/')?>/public/assets/img/demo/calendar_app.svg" alt="socail">
					</a>
				</div>
				<div class="col-xs-6 m-t-20 no-padding">
					<a href="#" class="p-l-10"><img src="<?=url('/')?>/public/assets/img/demo/add_more.svg" alt="socail">
					</a>
				</div>
			</div>
		</div>
		<!-- END SIDEBAR MENU TOP TRAY CONTENT-->
		<!-- BEGIN SIDEBAR MENU HEADER-->
		<div class="sidebar-header">
			Clients
			<div class="sidebar-header-controls">
				
				<button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
				</button>
			</div>

		</div>
		<!-- END SIDEBAR MENU HEADER-->
		<!-- START SIDEBAR MENU -->
		<div class="sidebar-menu">
			<!-- BEGIN SIDEBAR MENU ITEMS-->
			<!-- <div class="row">
				<div class="col-xs-6 no-padding">
					<a href="#" class="p-l-40"><img src="<?=url('/')?>/public/assets/img/demo/social_app.svg" alt="socail">
					</a>
				</div>
				<div class="col-xs-6 no-padding">
					<a href="#" class="p-l-10"><img src="<?=url('/')?>/public/assets/img/demo/email_app.svg" alt="socail">
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 m-t-20 no-padding">
					<a href="#" class="p-l-40"><img src="<?=url('/')?>/public/assets/img/demo/calendar_app.svg" alt="socail">
					</a>
				</div>
				<div class="col-xs-6 m-t-20 no-padding">
					<a href="#" class="p-l-10"><img src="<?=url('/')?>/public/assets/img/demo/add_more.svg" alt="socail">
					</a>
				</div>
			</div> -->
			<div class="m-t-10 " style="text-align:center;font-size:18px;color:#eee;">What Would You Like<br>To Do Today?</div>
			<ul class="menu-items">
				
				<li class="m-t-30 ">
					<a href="<?php echo url("/");?>/" class="detailed" style="overflow:visible">
							<span class="">Make a New Request</span>
					</a>
					<span class=" icon-thumbnail"><i class="fa fa-tasks"></i></span>
				</li>
				<li class="m-t-30 ">
					<a href="<?php echo url("/");?>/" class="detailed" style="overflow:visible">
							<span class="">Check Existing Request</span>
					</a>
					<span class=" icon-thumbnail"><i class="fa fa-archive"></i></span>
				</li>
				<li class="m-t-30 ">
					<a href="<?php echo url("/");?>/meeting" class="detailed" style="overflow:visible">
							<span class="">Schedule a Meeting</span>
					</a>
					<span class=" icon-thumbnail"><i class="fa fa-calendar"></i></span>
				</li>
		
				
				@if(\Auth::user()->user_type==2):
				?>
				<li class="m-t-30 ">
  
					<a href="<?php echo url("/");?>/settings" class="detailed">
							<span class="title">Settings</span>
					</a>

					<span class=" icon-thumbnail"><i class="fa fa-cogs"></i></span>
  
				</li>
				@endif
				

				 
			</ul>
			<div class="clearfix"></div>
		</div>
		<!-- END SIDEBAR MENU -->
	</nav>
	<!-- END SIDEBAR -->
	