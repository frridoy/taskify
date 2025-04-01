<?php

namespace App\Http\Controllers;

use App\Models\HelperFlag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {        $tasks = Task::with(['user', 'creator:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $list_title = "ALL Tasks";

        $users = User::where('role', 3)->where('status', 1)->get();

        return view('tasks.index', compact('tasks', 'list_title', 'users'));
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

            $created_by = Auth::id();

            Task::create([
                'task_name' => ucwords($request->task_name),
                'user_id' => $selectedUser->id,
                'status' => 0,
                'dateLimit' => $request->dateLimit,
                'task_description' => $request->task_description,
                'created_by' => $created_by,
            ]);

            $helperFlag->update([
                'assign_flag' => ($helperFlag->assign_flag + 1) % $totalUsers
            ]);


            notify()->success('Task assigned to ' . $selectedUser->name);
            return back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
}
