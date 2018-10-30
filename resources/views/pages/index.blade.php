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
                         <h1>What Would You Like To Do Today?</h1>
                         <div class="menu">
                             <a href="<?=url('/')?>/requests">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-new-request.png" alt="">
                                 <h2>Make a New Request</h2>
                                 <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem </p>
                             </a>
                             <a href="<?=url('/')?>/requests">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-check-existing.png" alt="">
                                 <h2>Check Exisiting Request</h2>
                                 <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem </p>
                             </a>
                             <a href="<?=url('/')?>/requests">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-urgen-request.png" alt="">
                                 <h2>Request an Urgent Task</h2>
                                 <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem </p>
                             </a>
                             <a href="<?php echo url("/");?>/meeting">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-schedule.png" alt="">
                                 <h2>Schedule a Meeting</h2>
                                 <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem </p>
                             </a>
                             <a href="#">
                                 <img src="<?=url('/')?>/public/assets/img/dashboard/icon-pay-invoice.png" alt="">
                                 <h2>Pay an Invoice</h2>
                                 <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem </p>
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
