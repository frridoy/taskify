@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Leave Request</h6>
                @if (auth()->user()->role == 3)
                    <a href="{{ route('leave_request') }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-person-walking"></i> Leave Request
                    </a>
                @endif
            </div>
            <div class="card-body">
                <!-- Filter Section -->
                {{-- <form action="{{ route('users.index') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label for="status_filter" class="form-label">Status</label>
                            <select name="status" id="status_filter" class="form-select">
                                <option value="">All Status</option>
                                <option value="1"
                                    {{ isset($_GET['status']) && $_GET['status'] == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0"
                                    {{ isset($_GET['status']) && $_GET['status'] == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="user" class="form-label">Users</label>
                            <select name="id" id="user" class="form-select select2">
                                <option value="">All Users</option>
                                @foreach ($users as $active_user)
                                    <option value="{{ $active_user->id }}"
                                        {{ isset($_GET['id']) && $_GET['id'] == $active_user->id ? 'selected' : '' }}>
                                        {{ $active_user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form> --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="leaveRequestTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Reason</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Request Days</th>
                                <th>Accpted Days</th>
                                <th>Status</th>
                                <th>Reviewed By</th>
                                @if(auth()->user()->role == 1 || auth()->user()->role == 1)
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($leave_requests->count() > 0)
                                @foreach ($leave_requests as $leave_request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $leave_request->user->name }}</td>
                                    <td>{{ config('static_array.leave_request_type')[$leave_request->leave_request_type]}}</td>
                                    <td>{{ $leave_request->reason_description }}</td>
                                    <td>{{ $leave_request->start_date }}</td>
                                    <td>{{ $leave_request->end_date }}</td>
                                    <td>{{ $leave_request->number_of_days_leave_requested}}</td>
                                    <td></td>
                                    <td class="text-center">
                                        @if ($leave_request->status == 0)
                                            ⏳
                                        @elseif ($leave_request->status == 1)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                    </td>
                                  <td></td>

                                  @if(auth()->user()->role == 1 || auth()->user()->role == 1)
                                  <td>
                                    <a href="" class="btn btn-sm btn-success" title="Approve">
                                        <i class="fas fa-spinner fa-spin">
                                    </a>
                                  </td>
                                  @endif

                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div>
                    {{$leave_requests->links()}}
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
