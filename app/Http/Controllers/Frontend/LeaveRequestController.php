<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;

class LeaveRequestController extends Controller
{
    public function leave_request()
    {
         $leave_request_type = config('static_array.leave_request_type');

        return view('frontend.leave.leave_request', compact('leave_request_type'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'leave_request_type' => 'required',
            'reason_description' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $userId = Auth::id();

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $totalDays = $start->diffInDaysFiltered(function (Carbon $date) {
            return !in_array($date->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]);
        }, $end);

        $leave_request = new LeaveRequest();
        $leave_request->user_id = $userId;
        $leave_request->start_date = $request->start_date;
        $leave_request->end_date = $request->end_date;
        $leave_request->number_of_days_leave_requested = $totalDays;
        $leave_request->status = 0;
        $leave_request->leave_request_type = $request->leave_request_type;
        $leave_request->reason_description = $request->reason_description;
        $leave_request->save();

        notify()->success("Leave request sent to the administrator with {$totalDays} days vacation.");
        return redirect()->back();
    }
}
