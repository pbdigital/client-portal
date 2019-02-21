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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Business</th>
                                    <th scope="col">Quickbooks Id</th>
                                    <th scope="col">Target Process Id</th>
                                    <th scope="col">Total Spent</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users_project as $project)
                                    @if($project->total_credits->total_spent) 
                                        <tr>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ ($project->quickbooks_client_id) ? $project->quickbooks_client_id : "--" }}</td>
                                            <td>{{ $project->project_id }}</td>
                                            <td>{{ $project->total_credits->total_spent }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                         
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
