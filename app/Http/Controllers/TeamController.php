<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function team_build()
    {
        $employees = User::where('role', 3)->where('status', 1)->get();
        return view('team.build', compact('employees'));
    }

    public function store(Request $request) {


        $validated = Validator::make($request->all(), [
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:users,id',
            'team_leader' => 'required|exists:users,id',
            'team_name' => 'required|unique:teams,team_name|string|max:255',
        ]);

        if ($validated->fails()) {
            notify()->error($validated->getMessageBag());
            return redirect()->back()->withInput();
        }

        $lastTeamNumber = DB::table('teams')->max('team_number');
        $newTeamNumber = $lastTeamNumber ? $lastTeamNumber + 1 : 1;

        foreach ($request->employee_id as $employeeId) {
            Team::create([
                'team_name' => ucwords($request->team_name),
                'employee_id' => $employeeId,
                'is_team_leader' => ($request->team_leader == $employeeId) ? 1 : 0,
                'team_number' => $newTeamNumber,
            ]);
        }

       notify()->success('Team created successfully.');
        return redirect()->back();
    }
}
