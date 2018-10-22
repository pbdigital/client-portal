<?php
namespace App;

class Asana
{
    static $url;
    static $project_id;
    static $task_id;
    static $api_url = "https://app.asana.com/api/1.0/";
    static $bearer = "Bearer 0/25a2b370e2dbcd73811a2d1446e1dcac";

    protected static function api_send(){
       
        $tasks = [];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::$api_url.self::$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: ".self::$bearer;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        $result = json_decode($result, true );

        if(!empty($result["data"])):
                
            $tasks  = $result["data"];

            return $tasks;
        else:
            return false;
        endif;
    } // api_send

    public static function set_project_id($project_id){
        self::$project_id = $project_id;
    } //set_project_id

    public static function set_task_id($task_id){
        self::$task_id = $task_id;
    } //set_task_id

    public static function get_tasks(){
        $url  = "projects/".self::$project_id."/tasks?opt_expand=memberships,id,name,completed";
        $url .= "&opt_fields=id,memberships,name,completed";
        //        $url .= ",workspace,parent,id,assignee,assignee_status,external,name,created_at,completed,completed_at";

//        $url .= ",due_at,due_on,followers,hearted,hearts,modified_at,notes,num_hearts,projects&opt_fields=workspace,";
      //  $url .= "memberships,id,assignee,external,name,parent,created_at,assignee_status,completed,completed_at,due_on";
       // $url .= ",due_at,followers,hearted,modified_at,hearts,notes,num_hearts,projects";

        self::$url = $url;
        return self::api_send();
    } // get_tasks

    public static function get_sections(){
        $url = "projects/".self::$project_id."/sections";
        self::$url = $url;
        return self::api_send();
    }

    public static function get_project_details(){
        $url = "projects/".self::$project_id."?opt_expand=name&opt_fields=name";
        self::$url = $url;
        return self::api_send();
    }

    public static function get_task_details(){
        self::$url = "tasks/".self::$task_id;
        return self::api_send();
    }

    public static function get_task_stories(){
        self::$url = "tasks/".self::$task_id."/stories";
        return self::api_send();
    } 

    public static function post_comment($args){
        $ch = curl_init();
        \App\Helper::debug(self::$api_url."tasks/".$args["task_id"]."/stories");

        curl_setopt($ch, CURLOPT_URL,self::$api_url."tasks/".$args["task_id"]."/stories");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"text=".urlencode($args["text"]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Authorization: ".self::$bearer;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $server_output = json_decode($server_output, true);
        #$response      = $server_output["data"];
        \App\Helper::debug($server_output);
       

    }

    public static function create_task($args){
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,self::$api_url."tasks");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"name=".urlencode($args["name"])."&notes=".urlencode($args["notes"])."&projects=".self::$project_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Authorization: ".self::$bearer;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $server_output = json_decode($server_output, true);
        $response      = $server_output["data"];

        $task_id  = $response["id"];

        
        // task file attachments
        if(!empty($task_id)):
            //POST /tasks/864390663868493/attachments?file=https%3A%2F%2Fclients.automationsuccess.local%2Fasana_files%2F1064725058_b.png
            if(!empty($args["files"])):

                foreach($args["files"] as $file):
                   
                    $file     = public_path().str_replace(url("/public/"),"", $file);
                    $fileinfo = pathinfo($file);
                    $filetype = mime_content_type($file );

                 
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,self::$api_url."tasks/".$task_id."/attachments");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    #curl_setopt($ch, CURLOPT_POSTFIELDS,"view_url=".urlencode($file) );
                    curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new \CURLFile($file, $filetype, $fileinfo["basename"] )]);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
                    $headers = array();
                    $headers[] = "Accept: application/json";
                    $headers[] = "Authorization: ".self::$bearer;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
                    $server_output = curl_exec($ch);
            
                    curl_close ($ch);
            
                    $server_output = json_decode($server_output, true);
                    #$response      = $server_output["data"];

                    \App\Helper::debug($server_output);
                endforeach;

            endif;
    
        endif;

    } // create_task
}