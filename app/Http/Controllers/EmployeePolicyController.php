<?php

namespace App\Http\Controllers;

use App\Models\EmployeePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Validator as FacadesValidator;

class EmployeePolicyController extends Controller
{
    public function employee_policy()
    {
        return view('employeePolicy.create');
    }
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'points_for_completed_tasks' => 'required|numeric',
            'amount_for_point' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $employeePolicy = new EmployeePolicy();
        $employeePolicy->points_for_completed_tasks = $request->input('points_for_completed_tasks');
        $employeePolicy->amount_for_point = $request->input('amount_for_point');
        $employeePolicy->save();
        notify()->success('Employee policy created successfully.');
        return redirect()->back();
    }
    public function edit($id)
    {
        $employee_policies = EmployeePolicy::findOrFail($id);
        return view('employeePolicy.create', compact('employee_policies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'points_for_completed_tasks' => 'required|numeric',
            'amount_for_point' => 'required|numeric',
        ]);

        $employeePolicy = EmployeePolicy::findOrFail($id);
        $employeePolicy->points_for_completed_tasks = $request->input('points_for_completed_tasks');
        $employeePolicy->amount_for_point = $request->input('amount_for_point');
        $employeePolicy->save();
        notify()->success('Employee policy updated successfully.');
        return redirect()->back();
    }
    public function index()
    {
        $employee_policies = EmployeePolicy::all();
        return view('employeePolicy.index', compact('employee_policies'));
    }
}
