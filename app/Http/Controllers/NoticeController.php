<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function notice()
    {

        $notice_types = config('static_array.notice_type');
        $user_types = config('static_array.user_type');

        $lastReference = Notice::orderBy('id', 'desc')
            ->select('reference_no')
            ->first();

        $last_reference_number = $lastReference ? $lastReference->reference_no : '';

        return view('notices.create', compact('notice_types', 'user_types', 'last_reference_number'));
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'notice_type' => 'required',
            'notice_for' => 'required',
            'expire_date' => 'required|after:publish_date',
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $is_active = $request->has('is_active') ? 1 : 0;

        $notice_for = json_encode($request->notice_for);

        $publish_date = $request->publish_date ?? Carbon::today()->toDateString();


        Notice::create([
            'title' => ucwords($request->title),
            'notice_type' => ucwords($request->notice_type),
            'notice_for' => $notice_for,
            'reference_no' => $request->reference_no,
            'meeting_date_time' => $request->meeting_date_time,
            'publish_date' => $publish_date,
            'expire_date' => $request->expire_date,
            'description' => $request->description,
            'is_active' => $is_active
        ]);

        notify()->success('Notice created successfully.');
        return redirect()->back();
    }

    public function index()
    {
        $user_types = config('static_array.user_type');
        $currentDate = Carbon::now();

        $authUser = Auth::user();
        $authId = $authUser->id;

        $team_leader = Team::where('user_id', $authId)
            ->where('is_team_leader', 1)
            ->first();

        if ($authUser->role == 1 || $authUser->role == 2) {
            $notices = Notice::orderBy('id', 'desc')->paginate(5);
        }
        else {
            if ($authUser->role == 3 && $team_leader) {
                $user_type_for_notice_get = "4";  //this $user_type_for_notice_get one form db where 4 is for team leader
            } elseif ($authUser->role == 3) {
                $user_type = "3";  //this one form db where 3 is for team leader
            } else {
                $user_type_for_notice_get = $authUser->role;
            }
            $notices = Notice::orderBy('id', 'desc')
                ->whereJsonContains('notice_for', $user_type_for_notice_get)
                ->where('publish_date', '<=', $currentDate)
                ->where('expire_date', '>=', $currentDate)
                ->where('is_active', 1)
                ->paginate(5);
        }
        return view('notices.index', compact('notices', 'user_types'));
    }
}
