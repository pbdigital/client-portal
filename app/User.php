<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'token', 'active', 'first_name', 'last_name', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    static function get_user_project_id(){
        $user_id = \AUTH::user()->id;
        #\App\Helper::debug($user_id);
        $result  = DB::table("users")
                    ->select("*")
                    ->where("id", $user_id)
                    ->get();


        if(!empty($result[0]->project_id)):
            return $result[0]->project_id;
        else:   
            return false;
        endif;
        
    } // get_useR_project_id

    static function get_users(){
        $users = DB::select(" SELECT * FROM `users` INNER JOIN user_asana_projects ON `users`.`id` = user_asana_projects.user_id  ");
        return $users;
    } // get_users
}