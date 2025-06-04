<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        if ($user->role == 1 || $user->role == 2) {
            $rewards = DB::table('rewards as r')
                ->join('users as s', 'r.user_id', '=', 's.id')
                ->select('r.user_id', 's.name', DB::raw('sum(r.total_amount_for_completed_task) as total_points'))
                ->when($request->filled('id'), function ($query) use ($request) {
                    return $query->where('r.user_id', $request->id);
                })
                ->when($fromDate, function ($query) use ($fromDate) {
                    return $query->whereDate('r.created_at', '>=', $fromDate);
                })
                ->when($toDate, function ($query) use ($toDate) {
                    return $query->whereDate('r.created_at', '<=', $toDate);
                })
                ->groupBy('r.user_id', 's.name')
                ->paginate(5);
        } else {
            $rewards = DB::table('rewards as r')
                ->join('users as s', 'r.user_id', '=', 's.id')
                ->select('r.user_id', 's.name', DB::raw('sum(r.total_amount_for_completed_task) as total_points'))
                ->where('r.user_id', $user->id)
                ->when($fromDate, function ($query) use ($fromDate) {
                    return $query->whereDate('r.created_at', '>=', $fromDate);
                })
                ->when($toDate, function ($query) use ($toDate) {
                    return $query->whereDate('r.created_at', '<=', $toDate);
                })
                ->groupBy('r.user_id', 's.name')
                ->paginate(5);
        }

        $employeePolicy = DB::table('employee_policies')->orderBy('id', 'desc')->first();

        $users = DB::table('users')
            ->select('id', 'name')
            ->where('role', 3)
            ->where('status', 1)
            ->get();

        return view('reward.index', compact('rewards', 'employeePolicy', 'users'));
    }
}
