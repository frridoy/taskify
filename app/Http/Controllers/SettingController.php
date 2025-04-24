<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function office_info_setup()
    {
        return view('settings.office_info_setup');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_location' => 'required',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'total_leave_days_for_employee_in_year' => 'required',
            'company_description' => 'required',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

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
        $office_info->total_leave_days_for_employee_in_year = $request->total_leave_days_for_employee_in_year;
        $office_info->company_description = $request->company_description;
        $office_info->company_facebook = $request->company_facebook;
        $office_info->company_twitter = $request->company_twitter;
        $office_info->company_linkedin = $request->company_linkedin;
        $office_info->save();

        notify()->success('Office info created successfully');
        return redirect()->route('office_info_setup.index');
    }

    public function edit($id)
    {
        $office_info = Setting::find($id);
        return view('settings.office_info_setup', compact('office_info'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_location' => 'required',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'total_leave_days_for_employee_in_year' => 'required',
            'company_description' => 'required',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $office_info = Setting::findOrFail($id);

        if ($request->hasFile('company_logo')) {
            if ($office_info->company_logo && file_exists(public_path('office/' . $office_info->company_logo))) {
                unlink(public_path('office/' . $office_info->company_logo));
            }

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
        $office_info->total_leave_days_for_employee_in_year = $request->total_leave_days_for_employee_in_year;
        $office_info->company_description = $request->company_description;
        $office_info->company_facebook = $request->company_facebook;
        $office_info->company_twitter = $request->company_twitter;
        $office_info->company_linkedin = $request->company_linkedin;

        $office_info->save();

        notify()->success('Office info updated successfully');
        return redirect()->route('office_info_setup.index');
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
