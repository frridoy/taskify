<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = DB::table('rewards as r')
            ->join('users as s', 'r.user_id', '=', 's.id')
            ->select('r.user_id', 's.name', DB::raw('sum(r.total_amount_for_completed_task)'))
            ->groupBy('r.user_id', 's.name')
            ->paginate(5);

        $employeePolicy = DB::table('employee_policies')
            ->orderBy('id', 'desc')->first();

        return view('reward.index', compact('rewards', 'employeePolicy'));
    }
}
