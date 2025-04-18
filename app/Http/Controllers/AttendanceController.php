<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function attendance()
    {
        $userId = Auth::id();
        $checkedInToday = Attendance::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->exists();
        $now = Carbon::now();
        return view('attendance.index', compact('checkedInToday'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $checkedInToday = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($checkedInToday) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        if ($request->input('location') == 0) {
            return redirect()->back()->with('error', 'Location is required.');
        }

        Attendance::create([
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'check_in'  => $now->format('H:i'),
            'location'  => $request->input('location'),
            'check_out' => null,
        ]);

        return redirect()->back()->with('success', 'Attendance recorded for today.');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $role = Auth::user()->role;

        $teamLeader = Team::where('user_id', $userId)
            ->where('is_team_leader', 1)
            ->first();

        if ($teamLeader) {
            $teamMemberIds = Team::where('team_number', $teamLeader->team_number)
                ->pluck('user_id')
                ->toArray();

            $userList = User::whereIn('id', $teamMemberIds)
                ->where('role', 3)
                ->where('status', 1)
                ->select(['id', 'name']);
        } elseif ($role == 1 || $role == 2) {
            $userList = User::where('status', 1)
                ->select(['id', 'name']);
        } else {
            $userList = User::where('id', $userId)
                ->select(['id', 'name']);
        }

        $users = $userList->get();


        $attendanceQuery = Attendance::with('user')->orderBy('created_at', 'desc');

        if ($role == 3 && !$teamLeader) {
            $attendanceQuery->where('user_id', $userId);
        }

        if ($request->filled('user_id')) {
            $attendanceQuery->where('user_id', $request->user_id);
        }

        if ($request->filled('from_date')) {
            $attendanceQuery->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $attendanceQuery->whereDate('created_at', '<=', $request->to_date);
        }

        $attendances = $attendanceQuery->paginate(10);

        return view('attendance.list', compact('attendances', 'users'));
    }
}
