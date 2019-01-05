<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TargetProcess;
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
    function priority_sort( $a, $b ){
        $p1 = $a['NumericPriority'];
        $p2 = $b['NumericPriority'];
        return (float)$p1 > (float)$p2;
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
            
			return view("pages.index");

		}
		
		return redirect(url('/').'/login');	
    } // index

    public function requests()
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
                $project_id = User::get_user_project_id();

                TargetProcess::set_project_id($project_id);
                $data = TargetProcess::get_everything();
               
                $features = array();
                $features[0]['NumericPriority'] = 0;
                foreach ($data['Features']['Items'] as $feature)
                {
                    $id = $feature['Id'];
                    $features[$id] = $feature;
                }
                
                foreach ($data['UserStories']['Items'] as $userstory)
                {
                    if (isset($userstory['Feature']['Id']))
                    {
                        $feature_id = $userstory['Feature']['Id'];
                    }
                    else
                    {
                        $feature_id = 0;
                    }
                    $features[$feature_id]['Tasks'][] = $userstory;
                }
                
                // exit;
                foreach ($data['Bugs']['Items'] as $bug)
                {
                    if (isset($bug['Feature']['Id']))
                    {
                        $feature_id = $bug['Feature']['Id'];
                    }
                    else
                    {
                        $feature_id = 0;
                    }
                    $features[$feature_id]['Tasks'][] = $bug;
                }
                //$features = array_reverse($features);
                foreach ($features as $key=>$feature)
                {
                    if (isset($feature['Tasks']))
                    {
                        usort( $features[$key]['Tasks'], array(__CLASS__ ,"priority_sort" ));                    
                    }
                }
           
                usort( $features, array($this ,"priority_sort" ));
                  

                return view("pages.asana.projects", array('data'=>$features));
            break; // load_project

            case "new_task_form":
                return view("pages.asana.new_task_form");
            break; // new_task_form

            case "save_new_task":
                $project_id = User::get_user_project_id();
                $args["project_id"]  = $project_id;
                $args["name"]  = $request->input("request_title");
                $args["notes"] = $request->input("description");
                $args["files"] = $request->input("files");
                
                TargetProcess::create_task( $args );
              
            break; //save_new_task


            case "task_details":
                $taskid = $request->input("taskid");
                
                TargetProcess::set_task_id($taskid);
                $data["task_details"] = TargetProcess::get_task_details();
                $data["stories"]      = TargetProcess::get_task_stories();
                //Remove anytext in enclosed <internal></internal> tags
                $notes = $data["task_details"]["notes"] ;
                $notes = preg_replace('/<internal>[\s\S]+?<\/internal>/', '', $notes);
                $data["task_details"]["notes"] = $notes;
               
                return view("pages.asana.task_details", $data);
            break; //task_details

            case "post_comment":
                $args["text"]    = $request->input("text");
                $args["task_id"] = $request->input("taskid");

                TargetProcess::post_comment($args);
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
    public function get_email()
    {
        return 'test';
    }
}
