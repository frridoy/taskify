<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
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

    public function leave_request_index()
    {
        $userId = Auth::id();

        $user_type = User::whereIn('role', [1, 2])
            ->where('status', 1)
            ->pluck('id')
            ->toArray();

        $isAdministrator = in_array($userId, $user_type);

        if ($isAdministrator) {
            $leave_requests = LeaveRequest::with('user:id,name')
            ->latest()
            ->paginate(2);
            $users = User::where('status', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        } else {

            $leave_requests = LeaveRequest::with('user:id,name')
                ->where('user_id', $userId)
                ->latest()
                ->paginate(2);

            $users = User::where('id', $userId)->select('id', 'name')->get();
        }

        return view('frontend.leave.leave_request_index', compact('leave_requests', 'users'));
    }

}
