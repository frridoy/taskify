<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            'check_in'  => $now->toTimeString(),
            'location'  => $request->input('location'),
            'check_out' => null,
        ]);

        return redirect()->back()->with('success', 'Attendance recorded for today.');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $attendances = Attendance::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('attendance.list', compact('attendances'));
    }

}
