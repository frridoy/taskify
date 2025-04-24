<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function office_info_setup()
    {
        return view('settings.office_info_setup');
    }

    public function store(Request $request)
    {
        $office_info = new Setting();
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('office'), $filename);
            $office_info->company_logo = $filename;
        }

        $office_info->company_name = $request->company_name;
        $office_info->company_location = $request->company_location;
        $office_info->check_in_time = $request->check_in_time;
        $office_info->check_out_time = $request->check_out_time;
        $office_info->company_email = $request->company_email;
        $office_info->company_phone = $request->company_phone;
        $office_info->company_address = $request->company_address;
        $office_info->company_website = $request->company_website;
        $office_info->total_leave_days_for_employee_in_year = $request->total_leave_days_for_employee_in_year;
        $office_info->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $office_info = Setting::find($id);
        return view('settings.office_info_setup', compact('office_info'));
    }

    public function index()
    {
        $office_info = Setting::first();

        if (!$office_info) {
            return redirect()->route('office_info_setup.form');
        }

        return view('settings.office_info_setup_list', compact('office_info'));
    }
}
