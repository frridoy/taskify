@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid py-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Salary Records</h6>
            </div>
            <div class="card-body">
                @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                    <form method="GET" action="{{ route('employee_salaries.records') }}" class="row g-2 mb-3">
                        <div class="col-md-3">
                            <select name="employee_id" class="form-select select2">
                                <option value="">Select Employee</option>
                                @foreach ($employees as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ request('employee_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="month" class="form-select">
                                <option value="">Select Month</option>
                                @foreach ($months as $key => $monthName)
                                    <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="year" class="form-control" placeholder="Enter Year"
                                value="{{ request('year') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('employee_salaries.records') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="salaryRecordsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>SI</th>
                                <th>Employee Name</th>
                                <th>Basic Salary</th>
                                <th>Bonus</th>
                                <th>Total Salary</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Distribute By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($salaryRecords->count() > 0)
                                @foreach ($salaryRecords as $salaryRecord)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $salaryRecord->user->name }}</td>
                                        <td>{{ $salaryRecord->basic_salary }}</td>
                                        <td>{{ $salaryRecord->bonus ?? '' }}</td>
                                        <td>{{ $salaryRecord->total_salary ?? '' }}</td>
                                        <td>{{ $months[$salaryRecord->month] }}</td>
                                        <td>{{ $salaryRecord->year ?? '' }}</td>
                                        <td>{{ $salaryRecord->distributeBy->name }}</td>
                                        <td class="text-center">
                                            @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                                                <a href="{{ route('employee-salaries.show', $salaryRecord->id) }}"
                                                    class="btn btn-sm btn-info" title="Show">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('employee_salary.details', $salaryRecord->id) }}"
                                                class="btn btn-sm btn-danger" title="Show">
                                                <i class="fas fa-list"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                @if (auth()->user()->role == 1 || (auth()->user()->role == 2 && $salaryRecords->count() > 0))
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body">
                                    @php
                                        $employeeName = request('employee_id')
                                            ? $employees[request('employee_id')] ?? 'Unknown'
                                            : null;
                                        $monthName = request('month') ? $months[request('month')] ?? '' : null;
                                        $year = request('year');
                                    @endphp

                                    <h6 class="card-title text-success">
                                        <strong>
                                            Total Summary
                                            @if ($employeeName || $monthName || $year)
                                                for
                                                {{ $employeeName ? $employeeName : 'All Employees' }}
                                                @if ($monthName)
                                                    {{ $monthName }}
                                                @endif
                                                @if ($year)
                                                    -{{ $year }}
                                                @endif
                                            @else
                                                (All Records)
                                            @endif
                                        </strong>
                                    </h6>

                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Basic Salary:</strong>
                                            {{ number_format($totals->total_basic_salary, 2) }}</li>
                                        <li><strong>Bonus:</strong> {{ number_format($totals->total_bonus, 2) }}</li>
                                        <li><strong>Total Salary:</strong> {{ number_format($totals->total_salary, 2) }}
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-end mt-3">
                    @if (isset($salaryRecords) && $salaryRecords->hasPages())
                        {{ $salaryRecords->appends(request()->all())->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
            padding: 0.5rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.25rem 0.4rem;
            font-size: 0.75rem;
        }

        .form-select,
        .form-control {
            border-radius: 0.25rem;
            font-size: 0.875rem;
            min-height: calc(1.5em + 0.5rem + 2px);
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-break {
            word-break: break-word !important;
            word-wrap: break-word !important;
        }

        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        @media (max-width: 767.98px) {

            .table th,
            .table td {
                font-size: 0.75rem;
                padding: 0.3rem;
            }
        }

        .gap-1 {
            gap: 0.25rem !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }
    </style>
@endsection
