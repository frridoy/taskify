<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function searchEngine()
    {
        $users = User::select('id', 'name')->orderBy('name')->get();
        return view('report.search_engine', compact('users'));
    }

    public function searchEngineResult(Request $request)
    {
        $query = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name as user_name');

        if ($request->filled('status')) {
            $query->where('tasks.status', $request->status);
        }

        if ($request->filled('user_name')) {
            $query->where('tasks.user_id', $request->user_name);
        }

        $tasks = $query->orderBy('tasks.created_at', 'desc')->get();

        $tasks = $tasks->map(function ($task) {
            switch ((int)$task->status) {
                case 0:
                    $task->status_text = 'Pending';
                    break;
                case 1:
                    $task->status_text = 'In Progress';
                    break;
                case 2:
                    $task->status_text = 'Completed';
                    break;
                default:
                    $task->status_text = 'Unknown';
            }
            return $task;
        });

        return response()->json($tasks);
    }
}
