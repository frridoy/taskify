<?php

namespace App\Http\Controllers;

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

        $user = Auth::id();

        $pending_tasks = Task::where('user_id', $user)
            ->where('status', 0)
            ->count();
        $processing_tasks = Task::where('user_id', $user)
            ->where('status', 1)
            ->count();
        $completed_tasks = Task::where('user_id', $user)
            ->where('status', 2)
            ->count();

        $missed_pending_tasks = Task::where('user_id', $user)
            ->where('status', 0)
            ->whereDate('dateLimit', '<', Carbon::now()->format('Y-m-d'))
            ->count();

        $missed_processing_tasks = Task::where('user_id', $user)
            ->where('status', 1)
            ->whereDate('dateLimit', '<', Carbon::now()->format('Y-m-d'))
            ->count();


        $total_tasks = $pending_tasks + $processing_tasks + $completed_tasks;
        return view('employee.dashboard', compact('pending_tasks', 'processing_tasks', 'completed_tasks', 'total_tasks', 'missed_pending_tasks', 'missed_processing_tasks'));
    }
    public function index()
    {
        $userId = Auth::id();

        $teamLeader = Team::where('employee_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('employee_id')
                ->toArray();

            $tasks = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->get();

            $list_title = 'My Team Tasks';
        } else {

            $tasks = Task::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            $list_title = $teamLeader ? 'My Team Tasks' : 'My Tasks';
        }

        $users = User::where('role', 3)->where('status', 1)->get();

        return view('tasks.index', compact('tasks', 'list_title', 'teamLeader', 'users', 'userId'));
    }

    public function pending_tasks()
    {
        $userId = Auth::id();

        $teamLeader = Team::where('employee_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('employee_id')
                ->toArray();

            $tasks = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->where('status', 0)
                ->get();

            $list_title = 'My Team Pending Tasks';
        } else {

            $tasks = Task::where('user_id', $userId)
                ->where('status', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            $list_title = $teamLeader ? 'My Team Pending Tasks' : 'My Pending Tasks';
        }

        $users = User::where('role', 3)->where('status', 1)->get();

        return view('tasks.index', compact('tasks', 'list_title', 'teamLeader', 'users', 'userId'));
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

    public function processing_tasks()
    {

        $userId = Auth::id();

        $teamLeader = Team::where('employee_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('employee_id')
                ->toArray();

            $tasks = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->where('status', 1)
                ->get();

            $list_title = 'My Team Processing Tasks';
        } else {

            $tasks = Task::where('user_id', $userId)
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get();

            $list_title = $teamLeader ? 'My Team Processing Tasks' : 'My Processing Tasks';
        }

        $users = User::where('role', 3)->where('status', 1)->get();

        return view('tasks.index', compact('tasks', 'list_title', 'users', 'teamLeader', 'userId'));
    }

    public function complete(Task $task)
    {
        if (Auth::user()->role == 3 && $task->status == 1) {
            $task->status = 2;
            $task->save();

            return redirect()->back()->with('success', 'Task completed successfully.');
        }
        return redirect()->back()->with('error', 'You are not authorized to complete this task.');
    }

    public function completed_tasks()
    {
        $userId = Auth::id();

        $teamLeader = Team::where('employee_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('employee_id')
                ->toArray();

            $tasks = Task::whereIn('user_id', $teamMemberIds)
                ->orderBy('created_at', 'desc')
                ->where('status', 2)
                ->get();

            $list_title = 'My Team Completed Tasks';
        } else {

            $tasks = Task::where('user_id', $userId)
                ->where('status', 2)
                ->orderBy('created_at', 'desc')
                ->get();

            $list_title = $teamLeader ? 'My Team Completed Tasks' : 'My Completed Tasks';
        }

        $users = User::where('role', 3)->where('status', 1)->get();

        return view('tasks.index', compact('tasks', 'list_title', 'users', 'teamLeader', 'userId'));
    }
}
