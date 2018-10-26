<?php
namespace App;

class ClickUp
{
    static $url;
    static $project_id;
    static $task_id;
    static $api_url = "https://api.clickup.com/api/v1/";
    static $bearer = "45d42d427dcd10b57278749d3071a231d94d5491";

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

        if(!empty($result)):
                
            $tasks  = $result;

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
        $url = "team/304732/task?project_ids[]=".self::$project_id;
        self::$url = $url;
        return self::api_send();
    } // get_tasks

    public static function get_sections(){
        $url = "space/308219/project";
        self::$url = $url;
        return self::api_send();
    }

    public static function get_project_details(){
        $url = "projects/".self::$project_id."?opt_expand=name&opt_fields=name";
        self::$url = $url;
       // return self::api_send();
    }

    public static function get_task_details(){
        self::$url = "tasks/".self::$task_id;
      //  return self::api_send();
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
        $name = $args['name'];
        $content = $args['notes'];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,self::$api_url."list/352369/task");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"name\": \"$name\",
            \"content\": \"$content\"
          }");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: ".self::$bearer;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $server_output = json_decode($server_output, true);

         $response      = $server_output;

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