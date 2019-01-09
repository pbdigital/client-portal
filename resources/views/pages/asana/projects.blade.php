<div class="requests-container">
        <div class="req-heading" style="margin:10px 0px;">
            <h3 class=""></h3>
         
            <div class="">
                <button id="new-req" type="button" class="btn btn-primary btn-sm btn-with-act" data-act="add_new_task">New Request</button>
            </div>   
        </div>
        <div class="clearfix"></div>
        <div class="card" style="margin:20px 0px">
            @php 
            $i=0;
            @endphp
            @foreach ($data as $feature)
                @if (isset($feature['EntityState']['Name']) && $feature['EntityState']['Name'] != "Closed" || empty($feature['Name']))
                    @isset($feature['Name'])
                        <h4>{{$feature['Name']}}</h4>
                    @else
                        <h4>General Requests</h4>
                    @endisset
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
                                        <div class="pull-right upper" >
                                            <div class="status"> <span class='badge' style='color:#fff;background:#48b0f7'>{{$task['EntityState']['Name']}}</span></div>
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
                                        <div class="card-title" style="margin:0px; padding:0px">
                                            {{$task['Name']}}
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding:0 15px;">
                                        <div class="collapse" id="collapse{{ $i}}">
                                        <p>@php echo (empty($task['Description'])) ? 'No Description' : $task['Description']; @endphp</p>
                                        </div> 
                                    </div>
                               </div>
                             @endif
                            @php $i++; @endphp
                        @endforeach
                    @else
                        <div class="card--inner">
                            <div class="card-header" 
                               data-toggle="collapse" 
                                data-target="#collapse{{ $i}}" 
                                aria-expanded="false" 
                                aria-controls="collapse{{ $i}}"
                                onclick="$(this).find('.fa').toggle();">
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
                                <div class="card-title" style="margin:0px; padding:0px">
                                    No Tasks Listed In This Section Yet
                                </div>
                            </div>
                            <div class="card-body" style="padding:0 15px;">
                                <div class="collapse" id="collapse{{ $i}}">
                                <p></p>
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