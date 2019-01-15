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
            <div class=" container-fluid   container-fixed-lg" id="div-custom-settings">

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
