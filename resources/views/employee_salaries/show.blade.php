@extends('admin.layouts.app')

@section('title', 'Salary Record Details')

@section('content')
    <style>
        .salary-details-card {
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.08);
            border-radius: 12px;
            border: none;
            background: #fff;
        }

        .salary-details-card .card-header {
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 24px 32px;
            border-bottom: none;
        }

        .salary-details-card .card-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .salary-details-table th,
        .salary-details-table td {
            vertical-align: middle;
            font-size: 1.08rem;
            padding: 14px 18px;
        }

        .salary-details-table th {
            background: #f8f9fa;
            color: #343a40;
            width: 35%;
            font-weight: 500;
            border-top: none;
        }

        .salary-details-table td {
            background: #fff;
            color: #495057;
            border-top: none;
        }

        .salary-details-card .card-footer {
            background: #f8f9fa;
            border-radius: 0 0 12px 12px;
            border-top: none;
            padding: 18px 32px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            border: none;
            border-radius: 6px;
            padding: 10px 28px;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3 0%, #007bff 100%);
        }

        @media (max-width: 767px) {

            .salary-details-card .card-header,
            .salary-details-card .card-footer {
                padding: 16px;
            }

            .salary-details-table th,
            .salary-details-table td {
                padding: 10px 8px;
                font-size: 1rem;
            }
        }
    </style>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card salary-details-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-check-alt mr-2"></i>
                            Salary Record for {{ $salaryRecord->user->name }}
                            ({{ $salaryMonth }}-{{ $salaryRecord->year }})
                        </h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped salary-details-table mb-0">
                            <tbody>
                                <tr>
                                    <th>Employee Name</th>
                                    <td>{{ $salaryRecord->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Basic Salary</th>
                                    <td>{{ number_format($salaryRecord->basic_salary, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Bonus</th>
                                    <td>{{ number_format($salaryRecord->bonus ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Salary</th>
                                    <td>
                                        {{ number_format($salaryRecord->total_salary ?? 0, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Month</th>
                                    <td>{{ $salaryMonth }}</td>
                                </tr>
                                <tr>
                                    <th>Year</th>
                                    <td>{{ $salaryRecord->year }}</td>
                                </tr>
                                <tr>
                                    <th>Processed By</th>
                                    <td>
                                        <i class="fas fa-user-check mr-1"></i>
                                        {{ $salaryRecord->distributeBy->name }}
                                    </td>
                                </tr>
                                @if ($salaryRecord->remarks)
                                    <tr>
                                        <th>Remarks</th>
                                        <td>
                                            <span class="text-muted">{{ $salaryRecord->remarks }}</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('employee_salaries.records') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection
