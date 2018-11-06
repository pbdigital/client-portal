<!DOCTYPE html>
<html>
	<head>
		@include('layouts.header')
	</head>
	<body class="fixed-header ">
		

		<!-- START PAGE-CONTAINER -->
		<div class="page-container ">
			<!-- START TOPBAR -->
			@include('layouts.topbar')
			<!-- END TOPBAR -->
		 
			<!-- START PAGE CONTENT WRAPPER -->
			<div class="page-content-wrapper ">
				<!-- START PAGE CONTENT -->
				<div class="content ">
					<!-- START CONTAINER FLUID -->
					<div class=" container-fluid   container-fixed-lg"  >
                            <!-- Calendly inline widget begin -->
<div class="calendly-inline-widget" data-url="https://calendly.com/pbdigital" style="min-width:320px;height:80vh;"></div>
<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
<!-- Calendly inline widget end -->
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
