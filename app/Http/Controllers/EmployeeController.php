<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {

        $user = Auth::user();

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
        $user = Auth::id();

        $tasks = Task::where('user_id', $user)
            ->orderBy('created_at', 'desc')
            ->get();
        $list_title = 'ALL Tasks';

        return view('tasks.index', compact('tasks', 'list_title'));
    }

    public function pending_tasks()
    {
        $user = Auth::id();
        $tasks = Task::where('user_id', $user)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $list_title = 'Pending Tasks';

        return view('tasks.index', compact('tasks', 'list_title'));
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

        $user = Auth::id();
        $tasks = Task::where('user_id', $user)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $list_title = 'Processing Tasks';

        return view('tasks.index', compact('tasks', 'list_title'));
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
        $user = Auth::id();
        $tasks = Task::where('user_id', $user)
            ->where('status', 2)
            ->orderBy('created_at', 'desc')
            ->get();

        $list_title = 'Completed Tasks';

        return view('tasks.index', compact('tasks', 'list_title'));
    }
}
