<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('status', 1)->whereIn('role', [1, 2, 3])->where('id', '!=', 1)->paginate(1000000);
        $rewards = DB::table('rewards as r')
            ->join('users as s', 'r.user_id', '=', 's.id')
            ->select('r.user_id', 's.name', DB::raw('sum(r.total_amount_for_completed_task) as total_points'))
            ->groupBy('r.user_id', 's.name');

        $bonus = $rewards->pluck('total_points', 'user_id');

        $salaryMonths = config('static_array.months');

        $currentMonth = now()->month;
        $selectedMonth = $currentMonth - 1;
        if ($selectedMonth == 0) {
            $selectedMonth = 12;
        }

        $selectedYear = now()->year;
        $years = [
            $selectedYear - 1,
            $selectedYear,
            $selectedYear + 1,
        ];

        return view('employee_salaries.index', compact('users', 'bonus', 'salaryMonths', 'selectedMonth', 'selectedYear', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $month = $request->input('selected_month');
        $year = $request->input('selected_year');
        $salaries = $request->input('salaries', []);

        foreach ($salaries as $salary) {
            if (!isset($salary['selected']) || !$salary['selected']) {
                continue;
            }

            $userId = $salary['user_id'];

            $exists = EmployeeSalary::where('month', $month)
                ->where('year', $year)
                ->where('user_id', $userId)
                ->exists();

            if ($exists) {
                continue;
            }

            EmployeeSalary::create([
                'user_id'      => $userId,
                'month'        => $month,
                'year'         => $year,
                'basic_salary' => $salary['basic_salary'],
                'bonus'        => $salary['bonus'],
                'total_salary' => $salary['total_salary'],
            ]);
        }

        notify()->success('Employee salaries distributed successfully.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        //
    }
}
