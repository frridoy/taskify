<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function searchEngine()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        $users = User::select('id', 'name')->orderBy('id')->get();
        return view('report.search_engine', compact('users'));
    }

    public function searchEngineResult(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        $query = DB::table('tasks')
            ->join('users as assigned_user', 'tasks.user_id', '=', 'assigned_user.id')
            ->join('users as creator_user', 'tasks.created_by', '=', 'creator_user.id')
            ->select(
                'tasks.*',
                'assigned_user.name as assigned_user_name',
                'creator_user.name as created_by_name'
            );

        if ($request->filled('status')) {
            $query->where('tasks.status', $request->status);
        }

        if ($request->filled('user_name')) {
            $query->where('tasks.user_id', $request->user_name);
        }

        if ($request->filled('created_by')) {
            $query->where('tasks.created_by', $request->created_by);
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
