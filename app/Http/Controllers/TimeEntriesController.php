<?php
namespace App\Http\Controllers;

use App\User;
use DB;


class TimeEntriesController extends Controller
{
     public function index()
     {
          $project_id = \Auth::user()->project_id;
          $rs = DB::select("SELECT * FROM tbl_credit_logs WHERE project_id = " . $project_id . " ORDER BY date desc");
          $time = DB::select("SELECT (sum(spent) - sum(spent * discount_percent / 100)) as spent FROM tbl_credit_logs WHERE project_id = " . $project_id);
          $time = $time[0]->spent;
          if ($time == null) {
               $time = 0;
          }
          return view("pages.settings.time", array('data' => $rs, 'time' => $time));
     }
     public function tp_receiver_add_entry()
     {

          $_POST = (json_decode(file_get_contents("php://input")));

          $data = $_POST->Entity;

          $project_id = $data->ProjectID;
          $spent = $data->Spent;
          $time_id = $data->TimeID;
          $assignable = $data->AssignableName;
          $tp_user_id = $data->UserID;

          $entries = DB::select(" SELECT * FROM tbl_credit_logs WHERE time_id = " . $time_id);
          if (empty($entries)) {
               $ins = DB::table('tbl_credit_logs')->insert(
                    [
                         'date' => date('Y-m-d H:i:s'),
                         'project_id' => $project_id,
                         'spent' => '-' . $spent,
                         'assignable' => $assignable,
                         'user_id' => $tp_user_id,
                         'time_id' => $time_id
                    ]
               );
               var_dump($ins);
          } else {
               DB::table('tbl_credit_logs')->where('time_id', $time_id)->update(['spent' => '-' . $spent]);
          }
     }

     public function invoicing()
     {
          $users = User::get();

          $users = $users->sortBy(function ($user) {
               return $user->total_credits->total_spent;
          });

          return view("pages.settings.invoicing", array('users_project' => $users));
     }
}
