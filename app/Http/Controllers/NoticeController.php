<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Setting;
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
            'is_active' => $is_active,
            'authorized_by' => Auth::user()->id,
        ]);

        notify()->success('Notice created successfully.');
        return redirect()->back();
    }

    // public function index(Request $request)
    // {
    //     $user_types = config('static_array.user_type');
    //     $currentDate = Carbon::now();

    //     $authUser = Auth::user();
    //     $authId = $authUser->id;

    //     $team_leader = Team::where('user_id', $authId)
    //         ->where('is_team_leader', 1)
    //         ->first();

    //         $query = Notice::orderBy('id', 'desc');

    //         // if ($request->has('title') && $request->title != '') {
    //         //     $query->where('title', $request->title);
    //         // }
    //         if ($request->has('title') && $request->title != '') {
    //             $query->where('title', 'like', '%' . $request->title . '%');
    //         }

    //     if ($authUser->role == 1 || $authUser->role == 2) {
    //         $notices = Notice::orderBy('id', 'desc')->paginate(5);
    //     } else {
    //         if ($authUser->role == 3 && $team_leader) {
    //             // dd($team_leader);
    //             $user_type_for_notice_get = "4";  //this $user_type_for_notice_get one form db where 4 is for team leader
    //         } elseif ($authUser->role == 3) {
    //             // dd($authUser->role);
    //             $user_type_for_notice_get = "3";  //this one form db where 3 is for employee
    //         } else {
    //             $user_type_for_notice_get = $authUser->role;
    //         }
    //         $notices = Notice::orderBy('id', 'desc')
    //             ->whereJsonContains('notice_for', $user_type_for_notice_get)
    //             ->where('publish_date', '<=', $currentDate)
    //             ->where('expire_date', '>=', $currentDate)
    //             ->where('is_active', 1)
    //             ->paginate(5);
    //     }
    //     return view('notices.index', compact('notices', 'user_types'));
    // }

    public function index(Request $request)
    {
        $user_types = config('static_array.user_type');
        $currentDate = Carbon::now();

        $authUser = Auth::user();
        $authId = $authUser->id;

        $team_leader = Team::where('user_id', $authId)
            ->where('is_team_leader', 1)
            ->first();

        $query = Notice::orderBy('id', 'desc');


        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($authUser->role == 1 || $authUser->role == 2) {
            $notices = $query->paginate(5);
        } else {

            if ($authUser->role == 3 && $team_leader) {

                $user_type_for_notice_get = "4";  // This value comes from the database, where 4 represents team leader
            } elseif ($authUser->role == 3) {

                $user_type_for_notice_get = "3";  // This value comes from the database, where 3 represents employee
            } else {

                $user_type_for_notice_get = $authUser->role;
            }

            $notices = $query->whereJsonContains('notice_for', $user_type_for_notice_get)
                ->where('publish_date', '<=', $currentDate)
                ->where('expire_date', '>=', $currentDate)
                ->where('is_active', 1)
                ->paginate(5);
        }

        return view('notices.index', compact('notices', 'user_types'));
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);

        $notice_types = config('static_array.notice_type');
        $user_types = config('static_array.user_type');

        $lastReference = Notice::orderBy('id', 'desc')
            ->select('reference_no')
            ->first();

        $last_reference_number = $lastReference ? $lastReference->reference_no : '';

        return view('notices.create', compact('notice_types', 'user_types', 'last_reference_number', 'notice'));
    }

    public function update(Request $request, $id)
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

        $notice = Notice::findOrFail($id);

        $is_active = $request->has('is_active') ? 1 : 0;
        $notice_for = json_encode($request->notice_for);
        $publish_date = $request->publish_date ?? Carbon::today()->toDateString();

        $notice->update([
            'title' => ucwords($request->title),
            'notice_type' => ucwords($request->notice_type),
            'notice_for' => $notice_for,
            // 'reference_no' => $request->reference_no,
            'meeting_date_time' => $request->meeting_date_time,
            'publish_date' => $publish_date,
            'expire_date' => $request->expire_date,
            'description' => $request->description,
            'is_active' => $is_active,
        ]);

        notify()->success('Notice updated successfully.');
        return redirect()->route('notice.edit', $notice->id);
    }

    public function view($id)
    {
        $notice = Notice::with(['user:id,name,designation,signature'])->findOrFail($id);
        $notice_types = config('static_array.notice_type');
        $user_types = config('static_array.user_type');
        $organization_info = Setting::select(['company_name', 'company_location', 'company_phone', 'company_email', 'company_logo'])->first();

        return view('notices.view', compact('notice', 'notice_types', 'user_types', 'organization_info'));
    }
}
