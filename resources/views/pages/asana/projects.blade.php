
<div class="" style="margin:10px 0px;">
    <div class="pull-right">
        <button type="button" class="btn btn-primary btn-sm btn-with-act" data-act="add_new_task">New Request</button>
    </div>
    <h3 class="pull-left">Welcome <?php if(!empty($project["name"])) echo $project["name"];?></h3>
</div>
<div class="clearfix"> </div>

<?php 
    $statuses = array("");

    ## regroup tasks
    $regroup_task = array();
    $group_name   = "New Requests";
    foreach($tasks as $etask):
        if(in_array($etask["completed"], $statuses )):
            if(substr_count($etask["name"],"*")==4):
                $group_name = $etask["name"];
            else:
                $regroup_task[$group_name][] = $etask;
            endif;
            
        endif;
    endforeach;
    ## end regroup tasks

    $i = 0;
    foreach($regroup_task as $group_name=>$tasks):
    ?>
        <div class="card" style="margin:10px 0px">
            <div class="card-header">
                <button style="padding:5px; background:none; border:none" class="pull-right" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#collapse<?php echo $i;?>" 
                        aria-expanded="false" 
                        aria-controls="collapse<?php echo $i;?>" 
                        onclick="$(this).find('.fa').toggle();"
                        >
                        <i class="fa fa-angle-up"></i>
                        <i class="fa fa-angle-down" style="display:none"></i>
                </button>
                <div class="card-title" style="margin:0px; padding:0px"><?php echo $group_name;?></div>
                
                
                
            </div>
            <div class="card-body" style="padding:0px">
                <div class="collapse show" id="collapse<?php echo $i;?>">
                    <table class="table  ">
                    
                        
                        <tbody>
                            <?php 
                            if(!empty($tasks)):
                                foreach($tasks as $etask):
                                    if(in_array($etask["completed"], $statuses )):
                                    ?>
                                    <tr class="btn-with-act" data-toggle="quickview" data-toggle-element="#quickview" data-act="open_quickview" data-taskid="<?php echo $etask["id"];?>" style="cursor:pointer">
                                        <td>
                                            <?php 
                                            $is_section   = false;
                                            
                                            if( sizeof($etask["memberships"]) >= 2 ):
                                                App\Asana::set_task_id($etask["id"]);
                                                $full_details = App\Asana::get_task_details();
                                            else:
                                                $full_details = false;
                                            endif;
                                            #debug($full_details);

                                            foreach($sections as $esec):
                                                if($esec["id"]==$etask["id"]) $is_section = true;
                                            endforeach;

                                            if( $is_section ):
                                                echo "<h6>".$etask["name"]."</h6>";
                                            else:
                                                echo $etask["name"];
                                            endif;
                                            ?>
                                        </td>
                                        <td>
                                            <div class="pull-right">
                                                <?php 
                                                if($etask["completed"]):
                                                    echo "<span class='badge badge-success'>Completed</span>";
                                                endif;

                                                if(!empty($full_details["memberships"][1])):
                                                    echo "<span class='badge badge-success'>".$full_details["memberships"][1]["section"]["name"]."</span>";
                                                endif;
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    endif;
                                
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
