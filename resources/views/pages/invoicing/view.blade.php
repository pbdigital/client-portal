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
                    <div class=" container-fluid   container-fixed-lg time-entries">
                        <div class="row">
                            <div class="col-md-12  mt-4">

                                <h3>Details :</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>User Name :</td>
                                            <td>{{ $user->name }} </td>
                                            <td>Email :</td>
                                            <td>{{ $user->name }} </td>
                                        </tr>
                                         <tr>
                                            <td>Quickbooks ID :</td>
                                            <td>{{ $user->quickbooks_client_id }} </td>
                                            <td>Target Process ID :</td>
                                            <td>{{ $user->project_id }} </td>
                                        </tr>
                                        <tr>
                                            <td>Total Spent:</td>
                                            <td colspan="3">{{ $user->total_credits->total_spent }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12 mt-4">
                                <h3>Credit Logs :</h3>
                                <table class="table" id="invoicing-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Time ID</th>
                                            <th>Assignable</th>
                                            <th>Spent</th>
                                            <th>Discount Percent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($credit_logs->count())
                                        @foreach ($credit_logs as $key => $credit_log)
                                            <tr>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $credit_log->time_id }}</td>
                                                <td>{{ $credit_log->assignable }}</td>
                                                <td>{{ $credit_log->spent }}</td>
                                                <td>{{ $credit_log->discount_percent }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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

        <script>
            $(document).ready( function () {
                $('#invoicing-table').DataTable();
            } );
        </script>
    </body>
</html>
