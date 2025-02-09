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

        return view('tasks.index', compact('tasks'));
    }

    // public function receive(Task $task)
    // {

    //     if ($task->status == 0) {
    //         $task->status = 1;
    //         $task->save();

    //         return redirect()->back();
    //     }
    //     return redirect()->route('tasks.index')->with('error', 'This task cannot be received as it is already processed or completed.');
    // }
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

}
