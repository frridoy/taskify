@extends('admin.layouts.app')
@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i>Salary Slip</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar avatar-xl mr-3">
                                    @if($salary->user->profile_photo)
                                        <img src="{{ asset('profile_photos/'.$salary->user->profile_photo) }}" alt="Profile" class="rounded-circle">
                                    @else
                                        <span class="avatar-title rounded-circle bg-secondary text-white">{{ substr($salary->user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $salary->user->name }}</h5>
                                </div>
                            </div>

                            <div class="bg-light p-3 rounded mb-3">
                                <p class="mb-1"><strong>ID:</strong> {{ $salary->user->id ?? '' }}</p>
                                <p class="mb-1"><strong>Designation:</strong> {{ $salary->user->designation ?? '' }}</p>
                                <p class="mb-1"><strong>Join Date:</strong> {{ $salary->user->joining_date ? $salary->user->joining_date->format('d M, Y') : '' }}</p>
                                 <p class="mb-1"><strong>Resign Date:</strong> {{ $salary->user->resignation_date ? $salary->user->resignation_date->format('d M, Y') : '' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Issued Date:</span>
                                    <strong>{{ now()->format('d F, Y') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Issued Time:</span>
                                    <strong>{{ now()->format('h:i A') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Print By:</span>
                                    <strong>{{ auth()->user()->name ?? '' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Payment Month:</span>
                                    <strong>{{ config('static_array.months')[$salary->month] ?? 'Unknown' }}, {{ $salary->year }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Earnings</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Basic Salary (Current)</td>
                                            <td>{{ number_format($salary->basic_salary, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bonus</td>
                                            <td>{{ number_format($salary->bonus, 2) }}</td>
                                        </tr>
                                        <tr class="table-success">
                                            <td><strong>Total Earnings</strong></td>
                                            <td><strong>{{ number_format($salary->total_salary, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="border p-3 text-center">
                                <p class="mb-1">_________________________</p>
                                <p class="mb-0">Employee Signature</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border p-3 text-center">
                                <p class="mb-1">_________________________</p>
                                <p class="mb-0">Authorized Signature</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-2" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Print Slip
                    </button>
                    <a href="" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-history mr-2"></i>Salary History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Basic</th>
                                    <th>Bonus</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Distributed By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allSalaries as $sal)
                                    <tr class="@if($sal->id == $salary->id) table-success @endif">
                                        <td>{{ config('static_array.months')[$sal->month] ?? 'Unknown' }}</td>
                                        <td>{{ $sal->year }}</td>
                                        <td>{{ number_format($sal->basic_salary, 2) }}</td>
                                        <td>{{ number_format($sal->bonus, 2) }}</td>
                                        <td>{{ number_format($sal->total_salary, 2) }}</td>
                                        <td>
                                            <span class="color-green">Paid</span>
                                        </td>
                                        <td>{{ $sal->created_at->format('d M, Y') }}</td>
                                        <td>{{ $sal->distributeBy->name ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($allSalaries->isEmpty())
                        <div class="alert alert-warning text-center mb-0">
                            No salary records found for this employee.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-xl {
        width: 60px;
        height: 60px;
    }
    .avatar-title {
        font-size: 1.5rem;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
        }
        .card-footer, .no-print {
            display: none !important;
        }
    }
</style>
@endsection
