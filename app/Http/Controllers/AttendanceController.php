<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
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
        $user = Auth::user();

        if ($user->role == 3) {
            $query = Attendance::with('user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc');
        } else {
            $query = Attendance::with('user')
                ->orderBy('created_at', 'desc');
        }

        $users = $query->get();

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

          // Filter by from date
    if ($request->has('from_date') && $request->from_date != '') {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    // Filter by to date
    if ($request->has('to_date') && $request->to_date != '') {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

        $attendances = $query->paginate(10);

        return view('attendance.list', compact('attendances', 'users'));
    }
}
