<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asana;
use App\User;
use DB;

class SettingsController extends Controller
{
    public static function index(){
        $data = [];

        return view("pages.settings", $data);
    } // index

    public static function settings_ajax(Request $request){
        $task = $request->input("task");

        switch($task):
            case "clients_list":
                $data["users"] = User::get_users();
                return view("pages.settings.users", $data);
            break; // clients_list

            case "add_user_form":
                return view("pages.settings.add_user_form");
            break; //add_user_form

            case "save_new_user":
                 
                $args["first_name"] = $request->input("first_name");
                $args["last_name"]  = $request->input("last_name");
                $args["name"]       = $request->input("first_name"). " ".$request->input("last_name");
                $args["email"]      = $request->input("email");
                $args["password"]   = bcrypt($request->input("password"));
                $args["user_type"]  = 1;
                $user_id = User::create($args)->id;
                
                $args = array();
                $args["asana_project_id"]     = $request->input("asana_project_id");
                $args["quickbooks_client_id"] = $request->input("quickbooks_client_id");
                $args["everhour_client_id"]   = $request->input("everhour_client_id");
                $args["user_id"]              = $user_id;

                DB::table("user_asana_projects")->insert($args);
            break; //save_new_user

            case "update_user_field":
            
                $field   = $request->input("field");
                $user_id = $request->input("userid");
                $val     = $request->input("val");

                $user_table_fields = array("first_name","last_name","email");

                if(in_array($field, $user_table_fields)):
                    $args[$field] = $val;
                    DB::table("users")
                        ->where("id", $user_id)
                        ->limit(1)
                        ->update($args);
                else:
                    $args[$field] = $val;
                    DB::table("user_asana_projects")
                        ->where("user_id", $user_id)
                        ->limit(1)
                        ->update($args);
                        
                endif;

            break; //update_user_field
            case "delete_user":
                $userid = $request->input("userid");
                DB::table("users")
                ->where("id",$userid)
                ->limit(1)
                ->delete();
            break; //delete_user
        endswitch;
    } // settings_ajax
}