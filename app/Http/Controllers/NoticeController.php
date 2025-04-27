<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use carbon\Carbon;

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
            'title' => $request->title,
            'notice_type' => $request->notice_type,
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
}
