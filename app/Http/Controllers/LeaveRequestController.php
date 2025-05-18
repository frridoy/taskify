<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LeaveRequestController extends Controller
{
    public function leave_request()
    {
        $leave_request_type = config('static_array.leave_request_type');

        $total_leave_days = Setting::value('total_leave_days_for_employee_in_year');

        $userId = Auth::user()->id;
        $currentYear = now()->year;

        $leave_spent_days = LeaveRequest::where('user_id', $userId)
            ->where('status', 1)
            ->whereYear('created_at', $currentYear)
            ->sum('number_of_days_leave_requested_accepted');

        $leave_days_left = $total_leave_days - $leave_spent_days;


        $pending_request = LeaveRequest::where('user_id', $userId)
            ->where('status', 0)
            ->get();

        return view('leave.leave_request', compact('leave_request_type', 'leave_days_left', 'leave_spent_days', 'pending_request'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_request_type' => 'required',
            'reason_description' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $userId = Auth::id();

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        // $totalDays = $start->diffInDaysFiltered(function (Carbon $date) {
        //     return !in_array($date->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]);
        // }, $end);

        $totalDays = $start->diffInDays($end);


        $total_leave_days = Setting::value('total_leave_days_for_employee_in_year');
        $currentYear = now()->year;

        $leave_spent_days = LeaveRequest::where('user_id', $userId)
            ->where('status', 1)
            ->whereYear('created_at', $currentYear)
            ->sum('number_of_days_leave_requested_accepted');

        $leave_days_left = $total_leave_days - $leave_spent_days;

        if ($totalDays > $leave_days_left) {

            notify()->error("{$totalDays} days vacation cannot be applied. You have {$leave_days_left} days left.");
            return redirect()->back()->withInput();
        }

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
        return redirect()->route('leave_request');
    }

    public function leave_request_index()
    {
        $userId = Auth::id();

        $user_type = User::whereIn('role', [1, 2])
            ->where('status', 1)
            ->pluck('id')
            ->toArray();

        $isAdministrator = in_array($userId, $user_type);

        if ($isAdministrator) {
            $leave_requests = LeaveRequest::with(['user:id,name', 'reviewedBy:id,name'])
                ->latest()
                ->paginate(10);
            $users = User::where('status', 1)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        } else {

            $leave_requests = LeaveRequest::with(['user:id,name', 'reviewedBy:id,name'])
                ->where('user_id', $userId)
                ->latest()
                ->paginate(10);

            $users = User::where('id', $userId)->select('id', 'name')->get();
        }

        return view('leave.leave_request_index', compact('leave_requests', 'users'));
    }

    public function action(Request $request, $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        if ($request->input('action') == 2) {
            $leaveRequest->status = 2;
            $leaveRequest->number_of_days_leave_requested_accepted = null;
        } else {
            $leaveRequest->status = 1;
            $leaveRequest->accepted_from_date = $request->accepted_from_date;
            $leaveRequest->accepted_to_date = $request->accepted_to_date;

            if ($request->accepted_from_date && $request->accepted_to_date) {
                $accepted_from_date = Carbon::parse($request->accepted_from_date);
                $accepted_to_date = Carbon::parse($request->accepted_to_date);
                $leaveRequest->number_of_days_leave_requested_accepted = $accepted_from_date->diffInDays($accepted_to_date) + 1;
            } else {
                $leaveRequest->number_of_days_leave_requested_accepted = null;
            }
        }

        $leaveRequest->comment = $request->comment;
        $leaveRequest->reviewed_by = Auth::id();
        $leaveRequest->reviewed_at = now();
        $leaveRequest->save();
        if (
            $leaveRequest->status == 1 &&
            $leaveRequest->accepted_from_date &&
            $leaveRequest->accepted_to_date
        ) {
            $from = Carbon::parse($leaveRequest->accepted_from_date);
            $to = Carbon::parse($leaveRequest->accepted_to_date);

            for ($date = $from->copy(); $date->lte($to); $date->addDay()) {
                $formattedDate = $date->toDateString();

                $attendance = Attendance::updateOrCreate(
                    [
                        'user_id' => $leaveRequest->user_id,
                        'leave_date' => $formattedDate,
                    ],
                    [
                        'check_in' => 'Leave',
                        'check_out' => null,
                        'location' => null,
                        'is_on_leave' => 1,
                        'leave_date' => $formattedDate,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                if (!$attendance->is_on_leave || !$attendance->leave_date) {
                    $attendance->is_on_leave = 1;
                    $attendance->leave_date = $formattedDate;
                    $attendance->save();
                }
            }
        }

        notify()->success('Leave request updated successfully.');
        return redirect()->back();
    }
}
