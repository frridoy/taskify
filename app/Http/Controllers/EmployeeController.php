<?php

namespace App\Http\Controllers;

use App\Models\EmployeePolicy;
use App\Models\Reward;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {

        $userId = Auth::id();

        $teamLeader = Team::where('user_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $pending_tasks = Task::whereIn('user_id', $teamMemberIds)
                ->where('status', 0)
                ->get();
        } else {

            $pending_tasks = Task::where('user_id', $userId)
                ->where('status', 0)
                ->get();
        }

        $pending_tasks_count = $pending_tasks->count();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $processing_tasks = Task::whereIn('user_id', $teamMemberIds)
                ->where('status', 1)
                ->get();
        } else {

            $processing_tasks = Task::where('user_id', $userId)
                ->where('status', 1)
                ->get();
        }

        $processing_tasks_count = $processing_tasks->count();


        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $completed_tasks = Task::whereIn('user_id', $teamMemberIds)
                ->where('status', 2)
                ->get();
        } else {

            $completed_tasks = Task::where('user_id', $userId)
                ->where('status', 2)
                ->get();
        }

        $completed_tasks_count = $completed_tasks->count();


        $missed_pending_tasks = Task::where('user_id', $userId)
            ->where('status', 0)
            ->whereDate('dateLimit', '<', Carbon::now()->format('Y-m-d'))
            ->count();

        $missed_processing_tasks = Task::where('user_id', $userId)
            ->where('status', 1)
            ->whereDate('dateLimit', '<', Carbon::now()->format('Y-m-d'))
            ->count();


        $total_tasks = $pending_tasks_count + $processing_tasks_count + $completed_tasks_count;

        return view('employee.dashboard', compact('pending_tasks_count', 'processing_tasks_count', 'completed_tasks_count', 'total_tasks', 'missed_pending_tasks', 'missed_processing_tasks'));
    }
    public function index(Request $request)
    {
        $userId = Auth::id();

        $teamLeader = Team::where('user_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $query = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc');
            $list_title = 'My Team Tasks';
        } else {

            $query = Task::where('user_id', $userId)
                ->orderBy('created_at', 'desc');

            $list_title = $teamLeader ? 'My Team Tasks' : 'My Tasks';
        }

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


        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
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

        return view('tasks.my_task', compact('tasks', 'list_title', 'teamLeader', 'users', 'userId'));
    }

    public function pending_tasks(Request $request)
    {
        $userId = Auth::id();

        $teamLeader = Team::where('user_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $query = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->where('status', 0);

            $list_title = 'My Team Pending Tasks';
        } else {

            $query = Task::where('user_id', $userId)
                ->where('status', 0)
                ->orderBy('created_at', 'desc');

            $list_title = $teamLeader ? 'My Team Pending Tasks' : 'My Pending Tasks';
        }

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


        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
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

        return view('tasks.pending_tasks', compact('tasks', 'list_title', 'teamLeader', 'users', 'userId'));
    }

    public function receive(Task $task)
    {
        if (Auth::user()->role == 3 && $task->status == 0) {
            $task->status = 1;
            $task->save();

            return redirect()->back()->with('success', 'Task received successfully.');
        }

        return redirect()->back()->with('error', 'You are not authorized to receive this task.');
    }

    public function graph()
    {
        return view('graph.view');
    }

    public function processing_tasks(Request $request)
    {

        $userId = Auth::id();

        $teamLeader = Team::where('user_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $query = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->where('status', 1);

            $list_title = 'My Team Processing Tasks';
        } else {

            $query = Task::where('user_id', $userId)
                ->where('status', 1)
                ->orderBy('created_at', 'desc');

            $list_title = $teamLeader ? 'My Team Processing Tasks' : 'My Processing Tasks';
        }

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


        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
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

        return view('tasks.processing_tasks', compact('tasks', 'list_title', 'users', 'teamLeader', 'userId'));
    }

    public function complete(Task $task)
    {
        if (Auth::user()->role == 3 && $task->status == 1) {
            $task->status = 2;
            $task->save();

            $today = date('Y-m-d');
            $dateLimit = $task->dateLimit;

            $employeePolicy = EmployeePolicy::where('id', 1)->first();

            $points = $employeePolicy->points_for_completed_tasks;
            $pointsForPerCompletedTask = $employeePolicy->amount_for_point;
            $totalAmountForCompletedTask = $points * $pointsForPerCompletedTask;

            if ($dateLimit >= $today) {
                Reward::create([
                    'user_id' => Auth::id(),
                    'task_id' => $task->id,
                    'points' => $points,
                    'amount_for_per_point_completed_task' => $pointsForPerCompletedTask,
                    'total_amount_for_completed_task' => $totalAmountForCompletedTask,
                ]);
            }

            return redirect()->back()->with('success', 'Task completed successfully.');
        }
        return redirect()->back()->with('error', 'You are not authorized to complete this task.');
    }

    public function completed_tasks(Request $request)
    {
        $userId = Auth::id();

        $teamLeader = Team::where('user_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $query = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->where('status', 2);

            $list_title = 'My Team Completed Tasks';
        } else {

            $query = Task::where('user_id', $userId)
                ->where('status', 2)
                ->orderBy('created_at', 'desc');

            $list_title = $teamLeader ? 'My Team Completed Tasks' : 'My Completed Tasks';
        }

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


        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
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

        return view('tasks.completed_tasks', compact('tasks', 'list_title', 'users', 'teamLeader', 'userId'));
    }
}
