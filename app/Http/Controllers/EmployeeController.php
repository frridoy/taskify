<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
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

    public function graph(){
        return view('graph.view');
    }

    public function processing_tasks(){
        $tasks = Task::where('user_id', auth()->id())
                     ->where('status', 1)
                     ->orderBy('created_at', 'desc')
                     ->get();
        $list_title = 'Processing Tasks';

        return view('tasks.index', compact('tasks', 'list_title'));
    }

    public function complete(Task $task){
        if(Auth::user()->role == 3 && $task->status == 1) {
            $task->status =2;
            $task->save();

            return redirect()->back()->with('success', 'Task completed successfully.');

        }
        return redirect()->back()->with('error', 'You are not authorized to complete this task.');

    }

    public function completed_tasks(){
        $tasks = Task::where('user_id', auth()->id())
                     ->where('status', 2)
                     ->orderBy('created_at', 'desc')
                     ->get();

        $list_title = 'Completed Tasks';

        return view('tasks.index', compact('tasks', 'list_title'));
    }

}
