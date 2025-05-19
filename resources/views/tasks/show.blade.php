@extends('setup.master')
@section('content')
<div class="container py-4">
    <!-- Page Header -->
    {{-- @if(auth()->user()->role == 1 || auth()->user()->role == 2)
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Task List
        </a>
        <h4 class="mb-0 text-dark fw-semibold">Task Details</h4>
        <div class="d-flex">
            <button onclick="window.print()" class="btn btn-sm btn-outline-primary ms-2">
                <i class="fas fa-print me-1"></i> Print
            </button>
        </div>
    </div>
    @else
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('my.tasks') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Task List
        </a>
        <h4 class="mb-0 text-dark fw-semibold">Task Details</h4>
        <div class="d-flex">
            <button onclick="window.print()" class="btn btn-sm btn-outline-primary ms-2">
                <i class="fas fa-print me-1"></i> Print
            </button>
        </div>
    </div>
    @endif --}}

    <!-- Main Card -->
    <div class="card shadow-sm border-0 mb-4">
        <!-- Card Header -->
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0 fw-semibold">{{ $task->task_name }}</h2>
                <div>
                    @if ($task->status == 0)
                        <span class="badge bg-white text-danger px-3 py-2 fw-bold">PENDING</span>
                    @elseif($task->status == 1)
                        <span class="badge bg-white text-warning px-3 py-2 fw-bold">IN PROGRESS</span>
                    @else
                        <span class="badge bg-white text-success px-3 py-2 fw-bold">COMPLETED</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
            <div class="row">
                <!-- Left Column - Task Details -->
                <div class="col-lg-8 pe-lg-4">
                    <!-- Task Description -->
                    <div class="mb-4">
                        <h5 class="text-dark mb-3 fw-semibold border-bottom pb-2">
                            <i class="fas fa-align-left text-primary me-2"></i>Description
                        </h5>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $task->task_description ?: 'No description provided' }}</p>
                        </div>
                    </div>

                    <!-- Task Timeline -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-dark mb-0 fw-semibold">
                                <i class="fas fa-history text-primary me-2"></i>Transfer History
                            </h5>
                            <span class="badge bg-primary px-3 py-1">{{ $task->transfers->count() }} Transfers</span>
                        </div>

                        @if($task->transfers->isEmpty())
                            <div class="alert alert-light mb-0">
                                <i class="fas fa-info-circle me-2"></i>No transfer history available.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr class="bg-light">
                                            <th scope="col" class="ps-3 text-uppercase small fw-bold text-muted">From</th>
                                            <th scope="col" class="text-uppercase small fw-bold text-muted">To</th>
                                            <th scope="col" class="text-uppercase small fw-bold text-muted">Transfer Date</th>
                                            <th scope="col" class="pe-3 text-uppercase small fw-bold text-muted">Initiated By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($task->transfers as $transfer)
                                            <tr class="border-bottom">
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="fw-semibold">{{ $transfer->oldUser->name ?? 'Unknown' }}</div>
                                                            <small class="text-muted">{{ $transfer->oldUser->email ?? '' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="fw-semibold">{{ $transfer->newUser->name ?? 'Unknown' }}</div>
                                                            <small class="text-muted">{{ $transfer->newUser->email ?? '' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($transfer->created_at)->format('d M, Y') }}</div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($transfer->created_at)->format('h:i A') }}</small>
                                                </td>
                                                <td class="pe-3">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="fw-semibold">{{ $transfer->transferredBy->name ?? 'Unknown' }}</div>
                                                            <small class="text-muted">{{ $transfer->transferredBy->email ?? '' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Task Meta -->
                <div class="col-lg-4 ps-lg-4">
                    <div class="sticky-top" style="top: 20px;">
                        <!-- Assignment Info -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="mb-0 text-dark fw-semibold">
                                    <i class="fas fa-info-circle text-primary me-2"></i>Task Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Due Date -->
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar-day text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small">Due Date</p>
                                        <p class="mb-0 fw-semibold">
                                            @if($task->dateLimit)
                                                {{ \Carbon\Carbon::parse($task->dateLimit)->format('d M, Y') }}
                                                <small class="d-block text-{{ \Carbon\Carbon::parse($task->dateLimit)->isPast() ? 'danger' : 'success' }}">
                                                    ({{ \Carbon\Carbon::parse($task->dateLimit)->diffForHumans() }})
                                                </small>
                                            @else
                                                No deadline
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Created Date -->
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar-plus text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small">Created On</p>
                                        <p class="mb-0 fw-semibold">
                                            {{ \Carbon\Carbon::parse($task->created_at)->format('d M, Y') }}
                                            <small class="d-block text-muted">
                                                ({{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }})
                                            </small>
                                        </p>
                                    </div>
                                </div>

                                <!-- Priority -->
                                <div class="d-flex align-items-start">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-flag text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted small">Priority</p>
                                        <p class="mb-0 fw-semibold">
                                            @if($task->priority == 'high')
                                                <span class="badge bg-danger">High</span>
                                            @elseif($task->priority == 'medium')
                                                <span class="badge bg-warning text-dark">Medium</span>
                                            @else
                                                <span class="badge bg-secondary">Low</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- People -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="mb-0 text-dark fw-semibold">
                                    <i class="fas fa-users text-primary me-2"></i>People
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Assignee -->
                                <div class="d-flex align-items-center mb-4">
                                    <div>
                                        <p class="mb-0 text-muted small">Assigned to</p>
                                        <p class="mb-0 fw-semibold">{{ $task->user->name ?? 'Unassigned' }}</p>
                                        <small class="text-muted">{{ $task->user->email ?? '' }}</small>
                                    </div>
                                </div>

                                <!-- Creator -->
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-muted small">Created by</p>
                                        <p class="mb-0 fw-semibold">{{ $task->creator->name ?? 'Unknown' }}</p>
                                        <small class="text-muted">{{ $task->creator->email ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="card-footer bg-white py-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Last updated: {{ \Carbon\Carbon::parse($task->updated_at)->format('d M, Y h:i A') }}</small>
                {{-- <div>
                    @if($task->status != 2 && (auth()->user()->role == 1 || auth()->user()->role == 2))
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit me-1"></i> Edit Task
                        </a>
                    @endif
                </div> --}}
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .avatar-sm {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }

    .card {
        border-radius: 0.5rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .table {
        font-size: 0.875rem;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        background-color: #f8f9fa;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1rem;
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .btn {
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }

    .fw-semibold {
        font-weight: 600;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .border-bottom {
        border-bottom: 1px solid #e9ecef !important;
    }

    @media print {
        .btn, .card-footer {
            display: none !important;
        }

        .container {
            width: 100%;
            max-width: none;
            padding: 0;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            margin: 0;
        }

        .card-header {
            background-color: #f8f9fa !important;
            color: #000 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
    }
</style>

@push('scripts')
<script>
    if (!document.querySelector('link[href*="font-awesome"]')) {
        const fontAwesome = document.createElement('link');
        fontAwesome.rel = 'stylesheet';
        fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
        document.head.appendChild(fontAwesome);
    }
</script>
@endpush
@endsection
