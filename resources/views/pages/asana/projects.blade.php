<div class="requests-container">
        <div class="req-heading" style="margin:10px 0px;">
            <!-- <h3 class="" style="display:none;"></h3> -->
            <div class="search">
                <input type="text" name="search" placeholder="Search for a task">
            </div>
            <div class="">
                <button id="new-req" type="button" class="btn btn-primary btn-sm btn-with-act" data-act="add_new_task">New Request</button>
            </div>   
        </div>
        <div class="clearfix"></div>
        <div class="card" style="margin:20px 0px">
                @php 
                $i=0;
                $color='';
                @endphp
                @foreach ($data as $feature)
                    @php
                        $open = 0;
                        $completed = 0;
                        $closed = 0;
                    @endphp
                    @isset($feature['Tasks'])
                        @foreach ($feature['Tasks'] as $task)
                            @if ($task['EntityState']['Name'] == "Completed")
                                @php 
                                    $completed++; 
                                @endphp
                            @else
                                @if ($task['EntityState']['Name'] != "Closed")
                                    @php 
                                        $open++; 
                                    @endphp
                                @else
                                    @php 
                                        $closed++; 
                                    @endphp
                                @endif
                            @endif 
                        @endforeach
                    @endisset




                    @if (isset($feature['EntityState']['Name']) && $feature['EntityState']['Name'] != "Done" || empty($feature['Name']))
                        <div class="card-holder">
                        @isset($feature['Name'])
                            <h4><i class="fa fa-angle-right" style=""></i> 
                                Feature: {{$feature['Name']}} <span class="open">{{$open}} open</span><span class="completed">{{$completed}} completed</span><span class="closed">{{$closed}} closed</span><div class="date"><img src="{{url('/')}}/public/assets/img/request-icon-calendar.png" alt=""><span>{{isset($feature['Release']['Name']) ? $feature['Release']['Name'] : 'TBA'}}</span></div> 
                            </h4>

                        @else
                            <h4><i class="fa fa-angle-down" style=""></i> 
                                General Requests <span class="open">{{$open}} open</span><span class="completed">{{$completed}} completed</span>
                            </h4>
                        @endisset
                        <div class="card-items" style="display:{{ $i==0 ? 'block' : 'none' }};">
                        @isset($feature['Tasks'])
                            @foreach ($feature['Tasks'] as $task)
                                @if ($task['EntityState']['Name'] != "Closed")
                                    <div class="card--inner">
                                        <div class="card-header" 
                                        data-toggle="collapse" 
                                            data-target="#collapse{{ $i}}" 
                                            aria-expanded="false" 
                                            aria-controls="collapse{{ $i}}"
                                            onclick="$(this).find('.fa').toggle();">
                                            <div class="card-title" style="margin:0px; padding:0px">
                                                {{$task['Name']}}
                                            </div>
                                            <div class="pull-right upper" >
                                                
                                                <div class="date"><img src="{{url('/')}}/public/assets/img/request-icon-calendar.png" alt=""><span>{{isset($task['Release']['Name']) ? $task['Release']['Name'] : 'TBA'}}</span></div>  
                                                <div class="status-container">
                                                    
                                                    <div class="status"> <span class='badge' style="color:#fff;
                                                    background:
                                                    @switch($task['EntityState']['Name'])
                                                        @case('Queued')
                                                            #81c683;
                                                            @break

                                                        @case('Request Received')
                                                            #42aefd;
                                                            @break

                                                        @case('Completed')
                                                            #008000;

                                                        @default
                                                           #48b0f7;
                                                    @endswitch
                                                    "
                                                    >{{$task['EntityState']['Name']}}</span></div>
                                                    <div class="time"><img src="{{url('/')}}/public/assets/img/dashboard/icon-clock.png" alt=""><span>  1h 1m</span></div>
                                                    <button style="margin-left:10px;padding:5px; background:none; border:none"
                                                            type="button" 
                                                            data-toggle="collapse" 
                                                            data-target="#collapse{{ $i}}" 
                                                            aria-expanded="false" 
                                                            aria-controls="collapse{{ $i}}" 
                                                            onclick="$(this).find('.fa').toggle();"
                                                            >
                                                            <i class="fa fa-angle-down" style="display:none"></i>
                                                            <i class="fa fa-angle-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                          
                                        </div>
                                        <div class="card-body" style="padding:0 15px;">
                                            <div class="collapse" id="collapse{{ $i}}">
                                                <div class="collapse-inner">
                                            <p>@php echo (empty($task['Description'])) ? 'No Description' : $task['Description']; @endphp</p>
                                            </div>
                                            </div> 
                                        </div>
                                    </div>

                               
                                @endif

                                @php $i++; @endphp
                                
                            @endforeach
                            </div>
                        </div>
                        @else
                            <div class="card--inner" style="display: none;">
                                <div class="card-header no-tasks" 
                                data-toggle="collapse" 
                                    data-target="#collapse{{ $i}}" 
                                    aria-expanded="false" 
                                    aria-controls="collapse{{ $i}}"
                                    onclick="$(this).find('.fa').toggle();">
                                    <div class="card-title" style="margin:0px; padding:0px">
                                        No Tasks Listed In This Section Yet
                                    </div>
                                    <div class="pull-right upper" >
                                        <div class="status"> <span class='badge' style='color:#fff;background:#48b0f7'></span></div>
                                            <div class="time"><img src="{{url('/')}}/public/assets/img/dashboard/icon-clock.png" alt=""><span>  1h 1m</span></div>
                                                <button style="margin-left:10px;padding:5px; background:none; border:none"
                                                        type="button" 
                                                        data-toggle="collapse" 
                                                        data-target="#collapse{{ $i}}" 
                                                        aria-expanded="false" 
                                                        aria-controls="collapse{{ $i}}" 
                                                        onclick="$(this).find('.fa').toggle();"
                                                        >
                                                        <i class="fa fa-angle-down" style="display:none"></i>
                                                        <i class="fa fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding:0 15px;">
                                            <div class="collapse" id="collapse{{ $i}}">
                                                <div class="collapse-inner">
                                                    <p></p>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @php $i++; @endphp
                        @endisset
                       
                    @endif
                @endforeach
            
        </div>

        @isset($_GET['type'])

        <script>
            $(document).ready(function(){
                $('#new-req').click();
            });
        </script>
        @endisset
</div>