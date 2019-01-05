<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TargetProcess;
use App\User;
use App\Helper;
use DB;

class NotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
            return json_encode(array('email'=>$user->email));
        }
        
    }
}
