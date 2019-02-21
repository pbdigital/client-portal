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

    protected $appends = ['total_credits'];

    public function creditLogs()
    {
        return $this->hasMany('App\Model\CreditLog', 'project_id', 'project_id');
    }

    /** 
     *  This is the total of creditd
     * @return object  
     */
    public function totalCredit()
    {
        $credit_logs = $this->creditLogs()->get();

        $total_credit = new \stdClass;
        $total_credit->project_id = null;
        $total_credit->total_spent = 0;
        $total_credit->discount_percent = 0;

        if ($credit_logs->count()) {
            foreach ($credit_logs as $credit) {
                $total_credit->project_id = $credit->project_id;
                $total_credit->total_spent += $credit->spent;
                $total_credit->discount_percent += $credit->discount_percent;
            }
        }

        return $total_credit;
    }

    public function getTotalCreditsAttribute()
    {
        return $this->totalCredit();
    }

    static function get_user_project_id()
    {
        $user_id = \AUTH::user()->id;
        #\App\Helper::debug($user_id);
        $result  = DB::table("users")
            ->select("*")
            ->where("id", $user_id)
            ->get();


        if (!empty($result[0]->project_id)): return $result[0]->project_id;
        else: return false;
        endif;
    } // get_useR_project_id

    static function get_users()
    {
        $users = DB::select(" SELECT * FROM `users` INNER JOIN user_asana_projects ON `users`.`id` = user_asana_projects.user_id  ");
        return $users;
    } // get_users
}
