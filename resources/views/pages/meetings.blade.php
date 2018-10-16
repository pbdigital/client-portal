<!DOCTYPE html>
<html>
	<head>
		@include('layouts.header')
	</head>
	<body class="fixed-header ">
		<!-- BEGIN SIDEBPANEL-->
		@include('layouts.sidebar')
		<!-- END SIDEBPANEL-->

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
                            <iframe src="https://automationsuccess.youcanbook.me/?noframe=true&skipHeaderFooter=true" id="ycbmiframeautomationsuccess" style="width:100%;height:1000px;border:0px;background-color:transparent;" frameborder="0" allowtransparency="true"></iframe><script>window.addEventListener && window.addEventListener("message", function(event){if (event.origin === "https://automationsuccess.youcanbook.me"){document.getElementById("ycbmiframeautomationsuccess").style.height = event.data + "px";}}, false);</script>
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
