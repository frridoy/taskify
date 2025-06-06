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

        $leaveDay = Attendance::where('user_id', $user->id)
            ->where('is_on_leave', 1)
            ->whereDate('created_at', Carbon::today())
            ->exists();
        if($leaveDay){
            return redirect()->back()->with('error', 'You are on leave today.');
        }

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

        if ($request->filled('leave_attendance')) {
            $attendanceQuery->where('is_on_leave', $request->leave_attendance);
        }

        $attendances = $attendanceQuery->paginate(10);

        return view('attendance.index', compact('attendances', 'users'));
    }

    public function checkOut($id)
    {
        $checkout = Attendance::findOrFail($id);
        return view('attendance.checkout', compact('checkout'));
    }
    public function checkOutUpdate($id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out.');
        }

        $attendance->check_out = Carbon::now()->format('H:i');
        $attendance->save();

        return redirect()->back()->with('success', 'You have checked out successfully.');
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'attendance_' . date('Ymd_His') . '.csv';
        $attendances = Attendance::with('user:id,name');

        if ($request->filled('from_date')) {
            $attendances->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $attendances->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('user_id')) {
            $attendances->where('user_id', $request->user_id);
        }

        if ($request->filled('leave_attendance')) {
            $attendances->where('is_on_leave', $request->leave_attendance);
        }

        $attendances = $attendances->orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['#', 'User ID', 'User Name', 'Check In', 'Check Out', 'Date', 'Is On Leave'];

        $callback = function () use ($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $loopIndex = isset($GLOBALS['attendance_csv_index']) ? ++$GLOBALS['attendance_csv_index'] : ($GLOBALS['attendance_csv_index'] = 1),
                    $attendance->user ? $attendance->user->id : '',
                    $attendance->user ? $attendance->user->name : '',
                    $attendance->check_in,
                    $attendance->check_out,
                    $attendance->created_at->format('Y-m-d'),
                    $attendance->is_on_leave ? 'Yes' : 'No'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
