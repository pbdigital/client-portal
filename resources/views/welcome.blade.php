<?php 
function debug($d){
    echo "<pre>";
        print_r($d);
    echo "</pre>";
}

$request_uri = substr($_SERVER["REQUEST_URI"],1);


function asana_api($url){
    $bearer = "Bearer 0/25a2b370e2dbcd73811a2d1446e1dcac";
    $tasks = [];

    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "Accept: application/json";
    $headers[] = "Content-Type: application/json";
    $headers[] = "Authorization: ".$bearer;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);

    $result = json_decode($result, true );

    $tasks  = $result["data"];

    return $tasks;
}



$statuses = array("");

$tasks    = asana_api("https://app.asana.com/api/1.0/projects/".$request_uri."/tasks?opt_expand=memberships,workspace,parent,id,assignee,assignee_status,external,name,created_at,completed,completed_at,due_at,due_on,followers,hearted,hearts,modified_at,notes,num_hearts,projects&opt_fields=workspace,memberships,id,assignee,external,name,parent,created_at,assignee_status,completed,completed_at,due_on,due_at,followers,hearted,modified_at,hearts,notes,num_hearts,projects");
$sections = asana_api("https://app.asana.com/api/1.0/projects/".$request_uri."/sections");
$project  = asana_api("https://app.asana.com/api/1.0/projects/".$request_uri."?opt_expand=name&opt_fields=name");
 

## regroup tasks
$regroup_task = array();
$group_name   = "nogroup";
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
 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Asana - <?php echo $request_uri;?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/litera/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body style="background:#f6f8f9">
    <section class="container">

        <h1 style="text-align: center;margin: 20px;">Welcome <?php if(!empty($project["name"])) echo $project["name"];?></h1>


        <?php 
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
                            <i class="fa fa-caret-up"></i>
                            <i class="fa fa-caret-down" style="display:none"></i>
                    </button>
                    <h6 class="card-title" style="margin:0px; padding:0px"><?php echo $group_name;?></h6>

                    
                    
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="collapse show" id="collapse<?php echo $i;?>">
                        <table class="table  ">
                        
                            
                            <tbody>
                                <?php 
                                foreach($tasks as $etask):
                                    if(in_array($etask["completed"], $statuses )):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            $is_section   = false;
                                            
                                            if( sizeof($etask["memberships"]) >= 2 ):
                                                $full_details = asana_api("https://app.asana.com/api/1.0/tasks/".$etask["id"]);
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
    </section>
</body>

</html>