<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asana;
use App\User;
use App\Helper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check())
		{
            
			return view("pages.home");

		}
		
		return redirect(url('/').'/login');	
    } // index

    public function home_ajax(Request $request){
        $task = $request->input("task");

        switch($task):

            case "load_project":
                $user_id    = \AUTH::user()->id;
                $project_id = User::get_user_asana_project_id();

                Asana::set_project_id($project_id);
                $data["tasks"]    = Asana::get_tasks();
                $data["sections"] = Asana::get_sections();
                $data["project"]  = Asana::get_project_details();
                return view("pages.asana.projects", $data);
            break; // load_project

            case "new_task_form":
                return view("pages.asana.new_task_form");
            break; // new_task_form

            case "save_new_task":
                $project_id = User::get_user_asana_project_id();
                Asana::set_project_id($project_id);
                
                $args["name"]  = $request->input("request_title");
                $args["notes"] = $request->input("description");
                $args["files"] = $request->input("files");

                
                Asana::create_task( $args );
              
            break; //save_new_task


            case "task_details":
                $taskid = $request->input("taskid");
                
                Asana::set_task_id($taskid);
                $data["task_details"] = Asana::get_task_details();
                $data["stories"]      = Asana::get_task_stories();
                //Remove anytext in enclosed <internal></internal> tags
                $notes = $data["task_details"]["notes"] ;
                $notes = preg_replace('/<internal>[\s\S]+?<\/internal>/', '', $notes);
                $data["task_details"]["notes"] = $notes;
               
                return view("pages.asana.task_details", $data);
            break; //task_details

            case "post_comment":
                $args["text"]    = $request->input("text");
                $args["task_id"] = $request->input("taskid");

                Asana::post_comment($args);
            break; // post comment

        endswitch;
    } //home_ajax

    public function file_upload(Request $request){
        $uploaded_files = array(); 
        $uploads_dir    = public_path().'/asana_files';
      
        $tmp_name = $_FILES["file"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
        $name = mt_rand().strtotime("now()")."_".basename($_FILES["file"]["name"]);
        if( move_uploaded_file($tmp_name, "$uploads_dir/$name") ){
            $upload_url = url("/public/asana_files/".$name);
        }

        echo $upload_url;

    } // file_upload
}
