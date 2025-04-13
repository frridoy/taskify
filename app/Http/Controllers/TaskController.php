<?php

namespace App\Http\Controllers;

use App\Models\HelperFlag;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $teamLeader = Team::where('employee_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('employee_id')
                ->toArray();

            $users = User::whereIn('id', $teamMemberIds)
                ->where('role', 3)
                ->where('status', 1)
                ->get();
        } else {
            $users = User::where('role', 3)
                ->where('status', 1)
                ->get();
        }

        $query = Task::with(['user', 'creator:id,name'])
            ->orderBy('created_at', 'desc');

        $list_title = "ALL Tasks";

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('urgency') && $request->urgency != '') {
            $query->where('task_urgency', $request->urgency);
        }

        $tasks = $query->paginate(10);

        $users = User::where('role', 3)->where('status', 1)->get();

        return view('tasks.index', compact('tasks', 'list_title', 'users', 'teamLeader', 'userId', 'teamMemberIds'));
    }

    public function assign()
    {
        return view('tasks.assign');
    }


    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string',
            'dateLimit' => 'nullable|date',
            'task_description' => 'nullable|string',
        ]);

        $users = User::where('role', 3)
            ->where('status', 1)
            ->orderBy('id')
            ->get(['id', 'name']);

        $totalUsers = $users->count();

        if ($totalUsers === 0) {
            return redirect()->back()->with('error', 'No active users found.');
        }

        $helperFlag = HelperFlag::firstOrCreate(
            ['id' => 1],
            ['assign_flag' => 0]
        );

        $selectedUser = $users[$helperFlag->assign_flag];
        $created_by = Auth::id();

        Task::create([
            'task_name' => ucwords($request->task_name),
            'user_id' => $selectedUser->id,
            'status' => 0,
            'dateLimit' => $request->dateLimit,
            'task_description' => $request->task_description,
            'created_by' => $created_by,
            'task_urgency' => $request->task_urgency,
        ]);

        $updateFlag = $helperFlag->assign_flag + 1;

        if ($updateFlag >= $totalUsers) {
            $updateFlag = 0;
        }

        $helperFlag->update([
            'assign_flag' => $updateFlag,
        ]);

        notify()->success('Task assigned to ' . $selectedUser->name);
        return back();
    }

    public function show($taskId)
    {
        $task = Task::with('transfers')->findOrFail($taskId);
        return view('tasks.show', compact('task'));
    }
}
