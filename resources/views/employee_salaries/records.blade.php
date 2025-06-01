@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Salary Records</h6>
            </div>
            <div class="card-body">
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
                                        <td>{{$months[$salaryRecord->month]}}</td>
                                        <td>{{ $salaryRecord->year ?? '' }}</td>
                                        <td>{{$salaryRecord->distributeBy->name}}</td>
                                        <td class="text-center">
                                            <a href="{{ route('employee-salaries.show', $salaryRecord->id) }}" class="btn btn-sm btn-info" title="Show">
                                                <i class="fas fa-eye"></i>
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
