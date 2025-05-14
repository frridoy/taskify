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

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="leaveRequestTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                {{-- <th>Reason</th> --}}
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Request Days</th>
                                <th>Accpted Days</th>
                                <th>Status</th>
                                <th>Reviewed By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($leave_requests->count() > 0)
                                @foreach ($leave_requests as $leave_request)
                                    {{-- <tr class="@if ($leave_request->status == 0) bg-pending @endif"> --}}
                                    <tr style="@if ($leave_request->status == 0) background-color: #ffebee; @endif">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $leave_request->user->name }}</td>
                                        <td>{{ config('static_array.leave_request_type')[$leave_request->leave_request_type] }}
                                        </td>
                                        {{-- <td>{{ $leave_request->reason_description }}</td> --}}
                                        <td>{{ $leave_request->start_date }}</td>
                                        <td>{{ $leave_request->end_date }}</td>
                                        <td class="text-center">{{ $leave_request->number_of_days_leave_requested }}</td>
                                        <td class="text-center">
                                            @if ($leave_request->number_of_days_leave_requested_accepted)
                                                {{ $leave_request->number_of_days_leave_requested_accepted }}
                                            @elseif($leave_request->number_of_days_leave_requested_accepted == 0)
                                                -
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($leave_request->status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($leave_request->status == 1)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $leave_request->reviewed_by ? \App\Models\User::find($leave_request->reviewed_by)->name : '-' }}
                                        </td>

                                        <td>
                                            @if ((auth()->user()->role == 1 || auth()->user()->role == 2) && $leave_request->status == 0)
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#leaveModal{{ $leave_request->id }}">
                                                    </i> Review
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $leave_request->id }}">
                                                </i> View
                                            </button>
                                        </td>

                                    </tr>
                                    <div class="modal fade" id="leaveModal{{ $leave_request->id }}" tabindex="-1"
                                        aria-labelledby="leaveModalLabel{{ $leave_request->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('leave_request_action', $leave_request->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title fw-bold">
                                                            <i class="fas fa-calendar-check me-2"></i>Review Leave Request
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-4">
                                                        <div class="employee-info mb-4 bg-light p-3 rounded-3">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3"
                                                                    style="width: 45px; height: 45px;">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">
                                                                        {{ $leave_request->user->name }}</h6>
                                                                    <small class="text-muted">Employee ID:
                                                                        {{ $leave_request->user->id ?? 'N/A' }}</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">Leave
                                                                        Type</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ config('static_array.leave_request_type')[$leave_request->leave_request_type] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">Requested
                                                                        Days</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ $leave_request->number_of_days_leave_requested }}
                                                                        days</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">Start
                                                                        Date</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ \Carbon\Carbon::parse($leave_request->start_date)->format('d M Y') }}
                                                                        ({{ \Carbon\Carbon::parse($leave_request->start_date)->format('l') }})
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">End
                                                                        Date</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ \Carbon\Carbon::parse($leave_request->end_date)->format('d M Y') }}
                                                                        ({{ \Carbon\Carbon::parse($leave_request->end_date)->format('l') }})
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="reason-box mb-4">
                                                            <label class="text-muted small text-uppercase">Reason for
                                                                Leave</label>
                                                            <div class="p-3 border rounded bg-light">
                                                                <p class="mb-0">{{ $leave_request->reason_description }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label for="accepted_days"
                                                                class="form-label text-muted small text-uppercase">Accepted
                                                                Days</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light">
                                                                    <i class="fas fa-check-circle text-primary"></i>
                                                                </span>
                                                                <input type="number" name="accepted_days"
                                                                    class="form-control form-control-lg"
                                                                    placeholder="Leave empty to use requested days"
                                                                    max="{{ $leave_request->number_of_days_leave_requested }}">
                                                            </div>
                                                            <small class="text-muted">Maximum:
                                                                {{ $leave_request->number_of_days_leave_requested }}
                                                                days</small>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="comment"
                                                                class="form-label text-muted small text-uppercase">Comment</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light">
                                                                    <i class="fas fa-check-circle text-primary"></i>
                                                                </span>
                                                                <input type="text" name="comment"
                                                                    class="form-control form-control-lg"
                                                                    placeholder="Leave empty to use requested days">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer border-0 pt-0">
                                                        <div class="d-flex justify-content-between w-100">
                                                            <button name="action" value="2" type="submit"
                                                                class="btn btn-outline-danger px-4 py-2">
                                                                <i class="fas fa-times-circle me-2"></i>Reject
                                                            </button>
                                                            <button name="action" value="1" type="submit"
                                                                class="btn btn-success px-4 py-2">
                                                                <i class="fas fa-check-circle me-2"></i>Approve
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- for view --}}
                                    <div class="modal fade" id="viewModal{{ $leave_request->id }}" tabindex="-1"
                                        aria-labelledby="viewModalLabel{{ $leave_request->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('leave_request_action', $leave_request->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title fw-bold">
                                                            </i>OverView Leave Request Info.
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-4">
                                                        <div class="employee-info mb-4 bg-light p-3 rounded-3">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3"
                                                                    style="width: 45px; height: 45px;">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">
                                                                        {{ $leave_request->user->name }}</h6>
                                                                    <small class="text-muted">Employee ID:
                                                                        {{ $leave_request->user->id ?? 'N/A' }}</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">Leave
                                                                        Type</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ config('static_array.leave_request_type')[$leave_request->leave_request_type] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label
                                                                        class="text-muted small text-uppercase">Requested
                                                                        Days</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ $leave_request->number_of_days_leave_requested }}
                                                                        days</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">Start
                                                                        Date</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ \Carbon\Carbon::parse($leave_request->start_date)->format('d M Y') }}
                                                                        ({{ \Carbon\Carbon::parse($leave_request->start_date)->format('l') }})
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label class="text-muted small text-uppercase">End
                                                                        Date</label>
                                                                    <p class="fw-bold mb-0">
                                                                        {{ \Carbon\Carbon::parse($leave_request->end_date)->format('d M Y') }}
                                                                        ({{ \Carbon\Carbon::parse($leave_request->end_date)->format('l') }})
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="leave-detail mb-3">
                                                                    <label
                                                                        class="text-muted small text-uppercase">Status</label>
                                                                    <p class="fw-bold mb-0">
                                                                        @if ($leave_request->status == 0)
                                                                            <span
                                                                                class="btn btn-warning btn-sm">Pending</span>
                                                                        @elseif ($leave_request->status == 1)
                                                                            <span
                                                                                class="btn btn-success btn-sm">Accepted</span>
                                                                        @elseif ($leave_request->status == 2)
                                                                            <span
                                                                                class="btn btn-danger btn-sm">Rejected</span>
                                                                        @else
                                                                            <span
                                                                                class="btn btn-secondary btn-sm">Unknown</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            @if ($leave_request->number_of_days_leave_requested_accepted)
                                                                <div class="col-md-6">
                                                                    <div class="leave-detail mb-3">
                                                                        <label
                                                                            class="text-muted small text-uppercase">Accepted
                                                                            days </label>
                                                                        <p class="fw-bold mb-0">
                                                                            {{ $leave_request->number_of_days_leave_requested_accepted ?? '' }}
                                                                            days</p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="reason-box mb-4">
                                                            <label class="text-muted small text-uppercase">Reason for
                                                                Leave</label>
                                                            <div class="p-3 border rounded bg-light">
                                                                <p class="mb-0">
                                                                    {{ $leave_request->reason_description ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                        @if ($leave_request->comment)
                                                            <div class="reason-box mb-4">
                                                                <label
                                                                    class="text-muted small text-uppercase">Comment</label>
                                                                <div class="p-3 border rounded bg-light">
                                                                    <p class="mb-0">{{ $leave_request->comment ?? '' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                    {{ $leave_requests->links() }}
                </div>
            </div>
        </div>

    </div>

    <style>
        tr[style*="background-color: #ffebee"] {
            background-color: #ef9a9a !important;
        }

        .table-hover tbody tr[style*="background-color: #ffebee"]:hover {
            background-color: #ae7474 !important;
        }
        tr[style*="background-color: #ffebee"] td {
            color: #333;
        }

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


        .modal-content {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .modal-header {
            padding: 1rem 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem 1.5rem;
        }

        .avatar-placeholder {
            font-size: 1.25rem;
        }

        .leave-detail label {
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
            letter-spacing: 0.5px;
        }

        .form-control-lg {
            height: calc(2.5rem + 2px);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn {
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }

        .btn-outline-danger:hover {
            transform: translateY(-1px);
        }

        /* Animation for modal appearance */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.fade.show .modal-dialog {
            transform: none;
        }
    </style>
@endsection
