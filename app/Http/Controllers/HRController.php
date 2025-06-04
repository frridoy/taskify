<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HRController extends Controller
{
    public function dashboard()
    {
        $pending_tasks = Task::where('status', 0)
            ->count();
        $processing_tasks = Task::where('status', 1)
            ->count();
        $completed_tasks = Task::where('status', 2)
            ->count();

        $missed_pending_tasks = Task::where('status', 0)
            ->whereDate('dateLimit', '<', Carbon::now()->format('Y-m-d'))
            ->count();

        $missed_processing_tasks = Task::where('status', 1)
            ->whereDate('dateLimit', '<', Carbon::now()->format('Y-m-d'))
            ->count();

        $total_missed_tasks = $missed_pending_tasks + $missed_processing_tasks;
        $total_tasks = $pending_tasks + $processing_tasks + $completed_tasks;

        return view('hr.dashbaord', compact('total_tasks', 'pending_tasks', 'processing_tasks', 'completed_tasks', 'missed_pending_tasks', 'missed_processing_tasks', 'total_missed_tasks'));
    }
}
