<?php

namespace App\Http\Controllers;

use App\User;

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
        $credit_logs = $user->creditLogs;

        return view("pages.invoicing.view", [
            'user' => $user,
            'credit_logs' => $credit_logs
        ]);
    }
}
