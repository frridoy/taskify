<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskNotificationController extends Controller
{
     public function task_notification(){
        $authid = Auth::id();
        $taskNotifications = TaskNotification::where('user_id', $authid)->paginate(5);
        return view('taskNotification.index', compact('taskNotifications'));
     }

     public function show($taskId, $notificationId)
     {
        TaskNotification::where('id', $notificationId)->delete(); // This will delete the notification with the given ID
        $task = Task::with('transfers')->findOrFail($taskId);
        return view('tasks.show', compact('task'));
     }
}
