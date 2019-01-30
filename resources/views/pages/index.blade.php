<!DOCTYPE html>
<html>
	<head>
		@include('layouts.header')
	</head>
	<body class="fixed-header ">
		<!-- BEGIN SIDEBPANEL-->
		
		<!-- END SIDEBPANEL-->

		<!-- START PAGE-CONTAINER -->
		<div class="page-container dashboard-menu">
			<!-- START TOPBAR -->
			@include('layouts.topbar')
			<!-- END TOPBAR -->
		 
			<!-- START PAGE CONTENT WRAPPER -->
			<div class="page-content-wrapper ">
				<!-- START PAGE CONTENT -->
				<div class="content ">
					<!-- START CONTAINER FLUID -->
					<div class=" container-fluid   container-fixed-lg">
                         <h1>Hi {{ Auth::user()->first_name }}, What Would You Like To Do Today?</h1>
                         <p><div class="heading" style="text-align: center;"><b>Account Balance:</b> You Have {{$time}} Hour(s) Available To Use</div></p>
                         <div class="menu">
                             <a href="<?=url('/')?>/requests/?type=new">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-new-request.png" alt="">
                                 <h2>Make a New Request</h2>
                                 <p>Use this to request something new to be done by us.</p>
                             </a>
                             <a href="<?=url('/')?>/requests">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-check-existing.png" alt="">
                                 <h2>Check Exisiting Request</h2>
                                 <p>Use this to check where an existing request you've made is at?</p>
                             </a>
                             <a href="<?=url('/')?>/requests?type=urgent">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-urgen-request.png" alt="">
                                 <h2>Request an Urgent Task</h2>
                                 <p>Need something done ASAP? Use this to make an urgent request</p>
                             </a>
                             <a href="<?php echo url("/");?>/meeting">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-schedule.png" alt="">
                                 <h2>Schedule a Meeting</h2>
                                 <p>Use this to schedule a 30 or 60 minute meeting.</p>
                             </a>
                             <a href="#">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-pay-invoice.png" alt="">
                                 <h2>Pay an Invoice</h2>
                                 <p>Pay an oustanding invoice. <br>(coming soon) </p>
                             </a>
                         </div>
					</div>
					<!-- END CONTAINER FLUID -->
				</div> <!-- .content -->
				<!-- END PAGE CONTENT -->
				<!-- START COPYRIGHT -->
				<!-- START CONTAINER FLUID -->
				<!-- START CONTAINER FLUID -->
				@include('layouts.footer')
				<!-- END COPYRIGHT -->
			</div>
			<!-- END PAGE CONTENT WRAPPER -->
			
			
		</div>
		<!-- END PAGE CONTAINER -->

		<!--START QUICKVIEW -->
		@include('layouts.quickview')
		<!-- END QUICKVIEW-->

		<!-- START OVERLAY -->
		@include('layouts.quickview')
		<!-- END OVERLAY -->

		<!-- BEGIN VENDOR JS -->
		@include('layouts.footerscripts')
		<!-- END PAGE LEVEL JS -->

 
		
	</body>
</html>
