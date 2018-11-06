<div class="requests-container">


<?php 
    $statuses = array("");


    ## regroup tasks
    $regroup_task = array();
    $group_name   = "New Requests";
   
    foreach ($sections['projects'] as $k=>$project)
    {
        if ($project['id'] == $project_id)
        {
            $sections = array();
            foreach ($project['lists'] as $list)
            {
                $sections[$list['id']]['name'] = $list['name'];
                $sections[$list['id']]['id'] = $list['id'];
            }
        }
    }
 
    if(!empty($tasks)):
        foreach($tasks['tasks'] as $etask):
             $list = $etask['list']['id'];
             $sections[$list]['task'][] = array('name'=> $etask['name'], 'status' => $etask['status'],'description' => $etask['text_content']);
             
        endforeach;
    endif; //if(!empty($tasks)):
    ## end regroup tasks
    $i = 0;
    $tasks = $sections;
    
    foreach($tasks as $k=>$task):
    
    ?>
        <div class="req-heading" style="margin:10px 0px;">
            <h3 class=""><?php echo $task['name'];?></h3>
            <?php if($i === 0): ?>
            <div class="">
                <button id="new-req" type="button" class="btn btn-primary btn-sm btn-with-act" data-act="add_new_task">New Request</button>
            </div>
            <?php endif; ?>
            
        </div>
        <div class="clearfix"></div>
        <div class="card" style="margin:20px 0px">
            <?php 
            if(!empty($tasks[$k]['task'])):
                $tasks[$k]['task'] = array_reverse($tasks[$k]['task'], true);
                foreach($tasks[$k]['task'] as $etask):
                    $status = $etask['status']['status'];
                    if ($status == "Open")
                    {
                        $status = 'Assigning Task';
                    }
                    ?>
                    <div class="card--inner">
                        <div class="card-header" 
                           data-toggle="collapse" 
                            data-target="#collapse<?php echo $i;?>" 
                            aria-expanded="false" 
                            aria-controls="collapse<?php echo $i;?>"
                            onclick="$(this).find('.fa').toggle();">
                            <div class="pull-right upper" >
                                <div class="status"><?php  echo "<span class='badge' style='color:#fff;background:".$etask['status']['color'].";'>". $status."</span>"; ?></div>
                                <div class="time"><img src="<?=url('/');?>/public/assets/img/dashboard/icon-clock.png" alt=""><span>  1h 1m</span></div>
                                <button style="margin-left:10px;padding:5px; background:none; border:none"
                                        type="button" 
                                        data-toggle="collapse" 
                                        data-target="#collapse<?php echo $i;?>" 
                                        aria-expanded="false" 
                                        aria-controls="collapse<?php echo $i;?>" 
                                        onclick="$(this).find('.fa').toggle();"
                                        >
                                        <i class="fa fa-angle-down" style="display:none"></i>
                                        <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                            <div class="card-title" style="margin:0px; padding:0px"><?php echo $etask['name']; ?></div>
                        </div>
                        <div class="card-body" style="padding:0 15px;">
                            <div class="collapse" id="collapse<?php echo $i;?>">
                            <p><?php echo nl2br($etask["description"]);?></p>
                            </div> 
                        </div>
                    </div>
                    <?php
                    
                        $i++;
                endforeach;
            endif; #if(!empty($tasks)):
            ?>
           
        </div>
    <?php 
    endforeach; #foreach($regroup_task as $group_name=>$tasks):
    ?>
    <?php
    if (isset($_GET['type'])):
    ?>
        <script>
            $(document).ready(function(){
                $('#new-req').click();
            });
        </script>
    <?php
    endif;
    ?>
</div>