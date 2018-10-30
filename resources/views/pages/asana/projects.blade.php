<div class="requests-container">
<div class="req-heading" style="margin:10px 0px;">
    <h3 class="">New Request <?php #if(!empty($project["name"])) echo $project["name"];?></h3>
    <div class="">
        <button id="new-req" type="button" class="btn btn-primary btn-sm btn-with-act" data-act="add_new_task">New Request</button>
    </div>
    
</div>
<div class="clearfix"> </div>

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
             $sections[$list]['task'][] = array('name'=> $etask['name'], 'status' => $etask['status']);
             
        endforeach;
    endif; //if(!empty($tasks)):
    ## end regroup tasks
    $i = 0;
    $tasks = $sections;
    
    foreach($tasks as $k=>$task):
    
    ?>
        <!-- <div class="card" style="margin:20px 0px" data-target="#modalSlideLeft" data-toggle="modal"> -->
        <div class="card" style="margin:20px 0px">
            <div class="card-header">
                 <div class="pull-right upper" >
                    <div class="status"><?php echo "<span class='badge badge-success'>". $etask['status']['status']."</span>"; ?></div>
                    <div class="time"><img src="<?=url('/');?>/public/assets/img/dashboard/icon-clock.png" alt=""><span>  1h 1m</span></div>
                    <button style="margin-left:10px;padding:5px; background:none; border:none"
                            type="button" 
                            data-toggle="collapse" 
                            data-target="#collapse<?php echo $i;?>" 
                            aria-expanded="false" 
                            aria-controls="collapse<?php echo $i;?>" 
                            >
                            <!-- onclick="$(this).find('.fa').toggle();" -->
                            <i class="fa fa-angle-down" style="display:none"></i>
                            <i class="fa fa-angle-right"></i>
                    </button>
                </div>
                <div class="card-title" style="margin:0px; padding:0px"><?php echo $task['name'];?></div>
                
                
                
            </div>
            <div class="card-body" style="padding:0px">
                <div class="collapse" id="collapse<?php echo $i;?>">
                    <table class="table  ">
                    
                        
                        <tbody>
                            <?php 
                            if(!empty($tasks[$k]['task'])):
           
                                foreach($tasks[$k]['task'] as $etask):
                                    ?>
                                    <tr class="btn-with-act" data-toggle="" data-toggle-element="#quickview" data-act="open_quickview" data-taskid="" >
                                        <td>
                                            <?php 
                                                echo $etask['name'];
                                            ?>
                                        </td>
                                        <td>
                                            <div class="pull-right" style="display:none;">
                                                <?php 
                                                    echo "<span class='badge badge-success'>". $etask['status']['status']."</span>";
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                
                                endforeach;
                            endif; #if(!empty($tasks)):
                            ?>
                        </tbody>
                    </table>
                </div> <!-- <div class="collapse" id="collapseExample"> -->
            </div>
        </div>
    <?php 
        $i++;
    endforeach; #foreach($regroup_task as $group_name=>$tasks):
    ?>
</div>