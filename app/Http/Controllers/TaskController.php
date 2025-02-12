<?php

namespace App\Http\Controllers;

use App\Models\HelperFlag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $list_title = "ALL Tasks";

        return view('tasks.index', compact('tasks', 'list_title'));
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
            'task_description' => 'nullable|string'
        ]);

        try {
            $users = User::where('role', 3)
                ->where('status', 1)
                ->orderBy('id')
                ->get();

            $totalUsers = $users->count();

            if ($totalUsers == 0) {
                return redirect()->back()->with('error', 'No active users found.');
            }

            $helperFlag = HelperFlag::firstOrCreate(
                ['id' => 1],
                ['assign_flag' => 0]
            );

            $selectedUser = $users[$helperFlag->assign_flag];

            Task::create([
                'task_name' => ucwords($request->task_name),
                'user_id' => $selectedUser->id,
                'status' => 0,
                'dateLimit' => $request->dateLimit,
                'task_description' => $request->task_description,
            ]);

            $helperFlag->update([
                'assign_flag' => ($helperFlag->assign_flag + 1) % $totalUsers
            ]);

            return redirect()->back()->with('success', 'Task assigned to ' . $selectedUser->name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
}
