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
                                <h3 class="float-left">Users Project:</h3>
                                <button class="btn btn-info float-right text-white" onclick="showProjectModal()">
                                    Add New Project
                                </button>
                                
                                <table class="table table-striped table-condensed" id="users-project-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Business</th>
                                            <th>Quickbooks Id</th>
                                            <th>Target Process Id</th>
                                            <th>Total Spent</th>
                                            <th>Total Balance</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users_project as  $key => $project)
                                            <tr>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>
                                                    <a href="{{ route('invoicing.show', ['project_id' => $project->project_id]) }}">
                                                        <span id="column-name-{{ $project->id }}"></span>{{ $project->name }}
                                                    </a>
                                                </td>
                                                <td id="column-quickbooks_client_id-{{ $project->id }}">{{ ($project->quickbooks_client_id) ? $project->quickbooks_client_id : "--" }}</td>
                                                <td id="column-project_id-{{ $project->id }}">{{ $project->project_id }}</td>
                                                <td>{{ $project->total_credits->total_spent }}</td>
                                                <td>{{ $project->total_credits->total_balance }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-xs" onclick="showProjectModal({{ json_encode($project) }})">
                                                        Update
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

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

                <!-- Credit Log Modal -->
                @include('pages.invoicing.project-modal')
                <!-- End Credit Log Modal -->
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
        
        @include('pages.invoicing.index-script')
    </body>
</html>
