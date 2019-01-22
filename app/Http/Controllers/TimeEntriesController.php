<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asana;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TblCreditsLogs;
use App\Models\TblCredits;
use Illuminate\Support\Facades\Log;


class TimeEntriesController extends Controller
{
	public function tp_receiver_add_entry(){
   
     	$_POST = (json_decode(file_get_contents("php://input")));

     	$data = $_POST->Entity;
     	
     	$project_id = $data->ProjectID;
     	$spent = $data->Spent;
     	$time_id = $data->TimeID;
     	$assignable = $data->AssignableName;
     	$tp_user_id = $data->UserID;

     	$entries = DB::select(" SELECT * FROM tbl_credit_logs WHERE time_id = ".$time_id);
     	if (empty($entries))
     	{
     		$ins = DB::table('tbl_credit_logs')->insert(
			    [
			    	'date' => date('Y-m-d H:i:s'),
			    	'project_id' => $project_id,
			    	'spent' => '-'.$spent,
			    	'assignable' => $assignable,
			    	'user_id' => $tp_user_id,
			    	'time_id' => $time_id
			    ]
			);
			var_dump($ins);
     	}
     	else
     	{
	     	DB::table('tbl_credit_logs')->where('time_id', $time_id)->update(['spent' => $spent]);
     	}
    }

}