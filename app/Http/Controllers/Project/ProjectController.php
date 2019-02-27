<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as Project;
use Hash;

class ProjectController extends Controller
{
    /** 
     * validatio array for store and update
     * 
     * @return array
     */
    protected function validateRulesArray()
    {
        return [
            'name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'project_id' => 'required|integer',
            'quickbooks_client_id' => 'required|integer'
        ];
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validateRulesArray());

        $project = new Project;
        $project->active = true;
        $project->user_type = 1;
        $project->name = $request->name;
        $project->first_name = $request->first_name;
        $project->last_name = $request->last_name;
        $project->email = $request->email;
        $project->password = Hash::make($request->password);
        $project->project_id = $request->project_id;
        $project->quickbooks_client_id = $request->quickbooks_client_id;
        $project->save();

        return response()->json([
            'project' => $project,
            'message' => $project->name . ' was added to project list.'
        ]);
    }

    public function update(Request $request, $project_id)
    {
        $rules_array = $this->validateRulesArray();
        $rules_array['name'] = 'required';
        $rules_array['email'] = 'required|email';

        unset($rules_array['password']);

        $this->validate($request, $rules_array);

        $project = Project::where('project_id', $project_id)->first();

        $project->name = $request->name;
        $project->first_name = $request->first_name;
        $project->last_name = $request->last_name;
        $project->project_id = $request->project_id;
        $project->quickbooks_client_id = $request->quickbooks_client_id;

        if ($project->email == $request->email) {
            // check if ther email already used by other
            if (Project::where('email', $request->email)->first()) {
                return response()->json(
                    [
                        "errors" => [
                            "quickbooks_client_id" => ["The email has already been taken."]
                        ]
                    ]
                );
            }
            $project->email = $request->email;
        }

        if ($request->password) {
            $project->password = Hash::make($request->password);
        }

        $project->update();

        return response()->json([
            'project' => $project,
            'message' => $project->name . ' project was updated.'
        ]);
    }
}
