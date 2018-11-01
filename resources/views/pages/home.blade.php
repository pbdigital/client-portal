<!DOCTYPE html>
<html>
	<head>
		@include('layouts.header')
	</head>
	<body class="fixed-header ">
		<!-- BEGIN SIDEBPANEL-->
	
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
					<div class=" container-fluid   container-fixed-lg" id="div-home-projects">
						 
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

		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click','.requests-container .card .card--inner', function() {
					$('.requests-container .card .card--inner').removeClass('active');
					$(this).addClass('active');
					$('#modalSlideLeft').modal('show');
					$(this).parent().parent().addClass('active');
					// if($(this).parent().hasClass('active')){

					// }else{
					// 	$(this).find('.card--inner').addClass('active');
						
						$('.modal-backdrop').hide();
						$('body').addClass('scroll-bar-active');
					// }
				});

				$('#modalSlideLeft').on('hidden.bs.modal', function () {
					$('.requests-container').removeClass('active');
					$('body').removeClass('scroll-bar-active');
				});
			});

		</script>
	</body>
</html>
