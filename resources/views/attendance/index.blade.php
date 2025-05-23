@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Attendance Management</h6>
                <a href="{{ route('attendance.provide') }}" class="btn btn-primary mt-2 mt-md-0">
                    <i class="fas fa-calendar-check"></i> Attendance
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('attendance.list') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label for="user" class="form-label">Users</label>
                            <select name="user_id" id="user_id" class="form-select select2">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('attendance.list') }}" class="btn btn-secondary">
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
                                <th>Check In</th>
                                <th>Check In Date</th>
                                <th>Check Out</th>
                                <th>Check Out Date</th>
                                @if (auth()->user()->role == 3)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$attendances->isEmpty())
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attendance->user->name }}</td>
                                    <td>
                                        @if ($attendance->is_on_leave == 1)
                                            <span class="badge bg-danger">On Leave</span>
                                        @else
                                            {{ $attendance->check_in }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->is_on_leave == 1)
                                            <span
                                                class="badge bg-danger">{{ \Carbon\Carbon::parse($attendance->leave_date)->format('d M, y') }}</span>
                                        @else
                                            {{ \Carbon\Carbon::parse($attendance->created_at)->format('d M, y') }}
                                        @endif
                                    </td>
                                    <td>{{ $attendance->check_out ? $attendance->check_out : '' }}</td>
                                    <td>
                                        @if ($attendance->check_out)
                                            {{ \Carbon\Carbon::parse($attendance->updated_at)->format('d M, y') }}
                                        @endif
                                    </td>
                                    @if (auth()->user()->role == 3 && $attendance->is_on_leave == 0)
                                        <td class="text-center">
                                            <a href="{{ route('check_out', $attendance->id) }}">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-danger">No attendance record found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    @if (isset($attendances) && $attendances->hasPages())
                        {{ $attendances->appends(request()->all())->links() }}
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
