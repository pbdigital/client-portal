<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TargetProcess;
use App\User;
use App\Helper;
use DB;
use Mail;
use App\Mail\TaskCreated;


class NotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $first_name;
    public $email;
    public $task_name;

    public function __construct()
    {
        //$this->middleware('auth');
    }
  
    public function get_email($project_id)
    {
        $user = DB::table('users')->where('project_id', $project_id)->first();
        //dd($users);
        if (isset($user))
        {
            $this->email = $user->email;
            $this->first_name = $user->first_name;
        }   
    }
    public function NewTaskCreated()
    {
        #this is the webhook receiver from Target Process
        $_POST = (json_decode(file_get_contents("php://input")));
        $data = $_POST;
        if (isset($data->ProjectId))
        {
            $this->get_email($data->ProjectId);
            if (isset($this->email))
            {
                $this->task_name = $data->Name;
                Mail::to($this->email)->cc('paul@pbdigital.com.au')->send(
                    new TaskCreated($this->first_name, $this->task_name)
                );
            }s  
        }
    }




}
