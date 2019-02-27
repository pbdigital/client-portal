<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\CreditLog;
use Illuminate\Http\Request;

class InvoicingController extends Controller
{
    public function index()
    {
        $users = User::get();

        $users = $users->sortBy(function ($user) {
            return $user->total_credits->total_spent;
        });

        return view("pages.invoicing.index", [
            'users_project' => $users
        ]);
    }

    public function show($project_id)
    {
        $user = User::where('project_id', $project_id)->first();
        $credit_logs = $user->creditLogs()->orderBy('date', 'DESC')->get();

        return view("pages.invoicing.view", [
            'user' => $user,
            'credit_logs' => $credit_logs
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'assignable' => 'required',
                'spent' => 'required|numeric',
                'discount_percent' => 'required|numeric'
            ]
        );

        $credit_log = CreditLog::find($id);
        $credit_log->assignable = $request->assignable;
        $credit_log->spent = $request->spent;
        $credit_log->discount_percent = $request->discount_percent;
        $credit_log->update();

        return response()->json([
            'credit_log' => $credit_log,
            'message' => '<strong>' . $credit_log->assignable . "</strong> was updated."
        ]);
    }

    public function delete($id)
    {
        $credit_log = CreditLog::find($id);

        if (!$credit_log) {
            return response()->json([
                'message' => 'No project was deleted.'
            ]);
        }

        $credit_log->delete();

        return response()->json([
            'message' => '<strong>' . $credit_log->assignable . "</strong> was deleted."
        ]);
    }
}
