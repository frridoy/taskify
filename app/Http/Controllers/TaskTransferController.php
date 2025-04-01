<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskTransferController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'new_user_id' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($id);
        $oldUserId = $task->user_id;
        $newUserId = $request->new_user_id;
        $transferredBy = Auth::id();

        TaskTransfer::create([
            'task_id' => $task->id,
            'old_user_id' => $oldUserId,
            'new_user_id' => $newUserId,
            'transferred_by' => $transferredBy,
            'task_description' => $task->task_description,
            'task_remark' => $request->task_remark,
        ]);

        $task->update(['user_id' => $newUserId]);

        notify()->success('Task transferred successfully');
        return redirect()->back();
    }
}
