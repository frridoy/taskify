<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class TeamController extends Controller
{
    public function teamBuild()
    {
        $already_under_a_team = Team::pluck('user_id')->toArray();

        $employees = User::where('role', 3)
            ->where('status', 1)
            ->whereNotIn('id', $already_under_a_team)
            ->get(['id', 'name']);

        return view('team.build', compact('employees'));
    }
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'user_id' => 'required|array',
            'user_id.*' => 'distinct|exists:users,id',
            'team_leader' => 'required|exists:users,id',
            'team_name' => 'required|unique:teams,team_name|string|max:255',
        ]);

        if ($validated->fails()) {
            notify()->error($validated->getMessageBag());
            return redirect()->back()->withInput();
        }

        $lastTeamNumber = DB::table('teams')->max('team_number');
        $newTeamNumber = $lastTeamNumber ? $lastTeamNumber + 1 : 1;

        foreach ($request->user_id as $employeeId) {
            Team::create([
                'team_name' => ucwords($request->team_name),
                'user_id' => $employeeId,
                'is_team_leader' => ($request->team_leader == $employeeId) ? 1 : 0,
                'team_number' => $newTeamNumber,
            ]);
        }

        notify()->success('Team created successfully.');
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $teamNames = Team::select('team_name')
            ->distinct()
            ->orderBy('team_name')
            ->pluck('team_name')
            ->toArray();

        $teams = Team::select('team_number', 'team_name')
            ->distinct('team_number')
            ->orderBy('team_number');

        if ($request->filled('user_id')) {
            $filteredTeamNumbers = Team::where('user_id', $request->user_id)
                ->pluck('team_number')
                ->toArray();

            $teams = $teams->whereIn('team_number', $filteredTeamNumbers);
        }

        if ($request->filled('team_name')) {
            $teams = $teams->where('team_name', $request->team_name);
        }

        $teams = $teams->get();

        $memberCounts = Team::selectRaw('team_number, COUNT(*) as member_count')
            ->groupBy('team_number')
            ->pluck('member_count', 'team_number')
            ->toArray();

        $teamSummary = collect();

        foreach ($teams as $team) {
            $teamSummary->push([
                'team_number' => $team->team_number,
                'team_name' => $team->team_name,
                'total_members' => $memberCounts[$team->team_number] ?? 0
            ]);
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $teamSummaryPaginated = new LengthAwarePaginator(
            $teamSummary->forPage($currentPage, $perPage),
            $teamSummary->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $userId = Team::select('user_id')
            ->distinct()
            ->with('employee:id,name')
            ->whereHas('employee', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        return view('team.index', compact('teamSummaryPaginated', 'userId', 'teamNames'));
    }

    public function view($team_number)
    {
        $team = Team::where('team_number', $team_number)->first();
        $members = Team::where('team_number', $team_number)->get();

        return view('team.view', compact('team', 'members'));
    }

    public function edit($team_number)
    {
        $teamMembers = Team::where('team_number', $team_number)
            ->with('employee:id,name')
            ->get();

        $currentMemberIds = $teamMembers->pluck('user_id')->toArray();

        $alreadyUnderTeam = Team::pluck('user_id')->toArray();

        $alreadyUnderTeam = array_diff($alreadyUnderTeam, $currentMemberIds);

        $employees = User::where('role', 3)
            ->where('status', 1)
            ->whereNotIn('id', $alreadyUnderTeam)
            ->get(['id', 'name']);

        return view('team.edit', compact('teamMembers', 'employees', 'team_number'));
    }

    public function update(Request $request, $team_number)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|array',
            'user_id.*' => 'distinct|exists:users,id',
            'team_leader' => 'required|exists:users,id',
            'team_name' => 'required|string|max:255',
        ]);

        if ($validated->fails()) {
            notify()->error($validated->getMessageBag());
            return redirect()->back()->withInput();
        }

        $existingTeamName = Team::where('team_name', $request->team_name)
            ->where('team_number', '!=', $team_number)
            ->exists();

        if ($existingTeamName) {
            notify()->error('The team name has already been taken.');
            return redirect()->back()->withInput();
        }

        Team::where('team_number', $team_number)
            ->whereNotIn('user_id', $request->user_id)
            ->delete();

        foreach ($request->user_id as $employeeId) {
            Team::updateOrCreate(
                ['team_number' => $team_number, 'user_id' => $employeeId],
                [
                    'team_name' => ucwords($request->team_name),
                    'is_team_leader' => ($request->team_leader == $employeeId) ? 1 : 0,
                ]
            );
        }

        notify()->success('Team updated successfully.');
        return redirect()->route('team.index');
    }
}
