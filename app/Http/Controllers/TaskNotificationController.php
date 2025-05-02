<?php

namespace App\Http\Controllers;

use App\Models\TaskNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskNotificationController extends Controller
{
     public function task_notification(){

        $authid = Auth::id();
        $taskNotification = TaskNotification::where('user_id', $authid)->get();
        return view('taskNotification.index', compact('taskNotification'));
     }
}
