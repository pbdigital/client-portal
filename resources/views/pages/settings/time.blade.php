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
                        <div class="heading"><b>Account Balance:</b> {{$time}} Hour(s) Available</div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Spent</th>
                                    <th scope="col">Time Used</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $time)
                                <tr>
                                    <td>{{date ('Y-m-d',strtotime($time->date))}}</td>
                                    <td>{{$time->spent * -1}}</td>
                                    <td>
                                        @if ($time->discount_percent > 0)
                                            @php 
                                                $discount = $time->spent * $time->discount_percent / 100;
                                                echo round($time->spent - $discount,2) * -1; 
                                            @endphp
                                        @else
                                        {{$time->spent * -1}}
                                        @endif
                                    </td>
                                    <td>{{$time->assignable }}</td>
                                </tr>
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
