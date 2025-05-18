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
        return view('attendance.checkin', compact('checkedInToday'));
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

            $users = User::whereIn('id', $teamMemberIds)
                ->where('role', 3)
                ->where('status', 1)
                ->select(['id', 'name'])
                ->get();
        } elseif ($role == 1 || $role == 2) {
            $users = User::where('status', 1)
                ->where('role', 3)
                ->select(['id', 'name'])
                ->get();
        } else {
            $users = User::where('id', $userId)
                ->select(['id', 'name'])
                ->get();
        }

        $attendanceQuery = Attendance::with(['user:id,name'])->orderBy('created_at', 'desc');
        dd($attendanceQuery->get());

        if ($role == 3) {
            if ($teamLeader) {
                $attendanceQuery->whereIn('user_id', $teamMemberIds);
            } else {
                $attendanceQuery->where('user_id', $userId);
            }
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

        return view('attendance.index', compact('attendances', 'users'));
    }

    public function check_out($id)
    {
        $checkout = Attendance::findOrFail($id);
        return view('attendance.checkout', compact('checkout'));
    }
    public function check_out_update($id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out.');
        }

        $attendance->check_out = Carbon::now()->format('H:i');
        $attendance->save();

        return redirect()->back()->with('success', 'You have checked out successfully.');
    }
}
