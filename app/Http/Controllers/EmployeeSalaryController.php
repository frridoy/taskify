<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $month = null, $year = null)
    {
        if (!$month || !$year) {
            return view('employee_salaries.select_month_year');
        }

        $users = User::where('status', 1)
            ->whereIn('role', [1, 2, 3])
            ->where('id', '!=', 1)
            ->paginate(1000000);

        $rewards = DB::table('rewards as r')
            ->join('users as s', 'r.user_id', '=', 's.id')
            ->select('r.user_id', 's.name', DB::raw('sum(r.total_amount_for_completed_task) as total_points'))
            ->whereMonth('r.created_at', $month)
            ->whereYear('r.created_at', $year)
            ->groupBy('r.user_id', 's.name');

        $bonus = $rewards->pluck('total_points', 'user_id');
        $salaryMonthName = config('static_array.months')[$month];

        $selectedMonth = $month;
        $selectedYear = $year;

        return view('employee_salaries.index', compact('users', 'bonus', 'selectedMonth', 'selectedYear', 'salaryMonthName'));
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
        $distribute_by = Auth::user()->id;

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
                'distribute_by' => $distribute_by
            ]);
        }

        notify()->success('Employee salaries distributed successfully.');
        return redirect()->back();
    }

    public function records(Request $request)
    {
        $user = Auth::user();
        $is_admin = $user->role == 1;
        $is_manager = $user->role == 2;

        $query = EmployeeSalary::with(['user:id,name', 'distributeBy:id,name']);

        if (!($is_admin || $is_manager)) {
            $query->where('user_id', Auth::id());
        } else {
            if ($request->filled('employee_id')) {
                $query->where('user_id', $request->employee_id);
            }
            if ($request->filled('month')) {
                $query->where('month', $request->month);
            }
            if ($request->filled('year')) {
                $query->where('year', $request->year);
            }
        }

        $sumQuery = clone $query;
        $salaryRecords = $query->paginate(10);
        $months = config('static_array.months');
        $employees = User::where('role', 3)->pluck('name', 'id');

        $totals = $sumQuery->selectRaw('
        SUM(basic_salary) as total_basic_salary,
        SUM(bonus) as total_bonus,
        SUM(total_salary) as total_salary')->first();

        return view('employee_salaries.records', compact('salaryRecords', 'months', 'employees', 'totals'));
    }


    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        $salaryRecord = EmployeeSalary::with(['user:id,name', 'distributeBy:id,name'])
            ->where('id', $employeeSalary->id)
            ->findorFail($employeeSalary->id);

        $salaryMonth = config('static_array.months')[$salaryRecord->month] ?? 'Unknown';

        return view('employee_salaries.show', compact('salaryRecord', 'salaryMonth'));
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

    public function perEmployeeDetails($id)
    {
        $salary = EmployeeSalary::with(['user:id,name,profile_photo,designation', 'distributeBy:id,name'])->findOrFail($id);

        $authID = Auth::user();
        $isEmployee = $authID->role == 3;

        if ($isEmployee) {
            if ($authID->id != $salary->user_id) {
                notify()->error('You do not have permission to view this page.');
                return redirect()->back();
            }
        }

        $allSalaries = EmployeeSalary::where('user_id', $salary->user_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('employee_salaries.employee_salary_details', compact('salary', 'allSalaries'));
    }
}
