<?php 
#\App\Helper::debug($stories);
?>
<div class="" style="padding: 0px 20px;position:relative;margin: 30px 0px;">

    <h5 contenteditable="true" style="font-weight:bold"><?php echo $task_details["name"]?></h5>
    <textarea class="form-control" style="min-height:250px"><?php echo $task_details["notes"];?></textarea>
    
    <div class="stories" style="
                            height: 60vh;
                            overflow: auto;
                        ">
    <?php 
    if(!empty($stories)):
        foreach($stories as $story):
            if($story["type"]=="comment"):    
                $words = explode(" ", $story["created_by"]["name"]);
                $acronym = "";

                foreach ($words as $w) {
                    $acronym .= $w[0];
                }
                #\App\Helper::debug($story);
            ?>
            <div  style="margin-top:20px">
                
                <div>
                    <span class="thumbnail-wrapper d32 circular inline bg-success"
                    style="
                        padding: 6px;
                        color: #fff;
                        margin-right:20px;
                        text-align:center;
                    "
                    ><?php echo $acronym;?></span> <?php echo $story["created_by"]["name"]?>

                    <span class="task-date" style="font-size:12px; color:#999; padding-left:10px;"><?php echo \App\Helper::prettyfy_datestamp($story["created_at"]);?></span>

                </div>
                <div class="p-l-10 " style="margin-top:10px; color:#000">
                    <?php echo $story["text"];?>
                </div>
            </div>
            <?php 
            endif;
            
        endforeach;
    endif;
    ?>
    </div>

    <div style="position: absolute;width: 93%;bottom: 0%;">
        <button type="button" class="btn btn-sm btn-primary btn-with-act" data-act="save_comment" data-taskid="<?php echo $task_details["id"];?>" style="position:absolute; right:20px; top:8px; ">Save</button>
        <textarea class="form-control task-text-comment" placeholder="Write comment ... "></textarea>
    </div>
</div>

