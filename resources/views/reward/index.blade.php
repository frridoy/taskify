@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            @if(auth()->user()->role == 1 || auth()->user()->role == 2)
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Reward Management</h6>
                @if ($employeePolicy)
                    <a href="{{ route('employee_policy.edit', $employeePolicy->id) }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-pen"></i> Edit Policy                    </a>
                @else
                    <a href="{{ route('employee_policy') }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-file-alt"></i> Create Policy
                    </a>
                @endif
            </div>
            @endif
            <div class="card-body">
                <!-- Filter Section -->
                <form action="{{ route('reward.index') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label for="user" class="form-label">Users</label>
                            <select name="id" id="user" class="form-select select2">
                                <option value="">All Users</option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('reward.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Total Point</th>
                                <th>Current Month</th>
                                <th>Last Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rewards->count() > 0)
                                @foreach ($rewards as $reward)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ $reward->{'sum(r.total_amount_for_completed_task)'} }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    @if (isset($rewards) && $rewards->hasPages())
                        {{ $rewards->appends(request()->all())->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Base Styles */
        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
            padding: 0.5rem;
        }

        /* Table Styling */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Cards and UI Components */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        /* Button and Badge Styling */
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.25rem 0.4rem;
            font-size: 0.75rem;
        }

        /* Form Controls */
        .form-select,
        .form-control {
            border-radius: 0.25rem;
            font-size: 0.875rem;
            min-height: calc(1.5em + 0.5rem + 2px);
        }

        /* Text handling */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-break {
            word-break: break-word !important;
            word-wrap: break-word !important;
        }

        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        /* Responsive Adjustments */
        @media (max-width: 767.98px) {

            .table th,
            .table td {
                font-size: 0.75rem;
                padding: 0.3rem;
            }
        }

        /* Utility classes */
        .gap-1 {
            gap: 0.25rem !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }
    </style>
@endsection
