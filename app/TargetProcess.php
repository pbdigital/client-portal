<?php
namespace App;

class TargetProcess
{
    static $url;
    static $project_id;
    static $list_id;
    static $task_id;
    static $api_url = "https://pbdigital.tpondemand.com/api/v1/";
    static $bearer = "Basic cGF1bEBwYmRpZ2l0YWwuY29tLmF1OlRhYmF0aGEx";

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
    
    public static function set_list_id($list_id){
        self::$list_id = $list_id;
    } //set_list_id

    public static function set_task_id($task_id){
        self::$task_id = $task_id;
    } //set_task_id

    public static function get_tasks(){
        $url = "team/304732/task?project_ids[]=".self::$project_id;
        self::$url = $url;
        return self::api_send();
    } // get_tasks

    public static function get_sections(){
        $url = "Projects/192?include=[Features]";
        self::$url = $url;
        return self::api_send();
    }
    public static function get_everything()
    {   
        $url = "Projects/192?include=[Features[EntityState,Name],UserStories[Feature,Name,EntityState],Bugs[Feature,Name,EntityState]]";
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
        $project_id = $args['project_id'];
        $ch = curl_init();
        $json = '
        {
            "Name":"'.$name.'",
            "Description":"'.$content.'",
            "Project":{"Id":'.$project_id.'}
        }
        ';

        curl_setopt($ch, CURLOPT_URL,self::$api_url."UserStories");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: ".self::$bearer;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $server_output = json_decode($server_output, true);

        $response      = $server_output;
        print_r($server_output);
        exit;

    } // create_task
}