@extends('setup.master')
@section('content')
<div class="container py-4">
    <!-- Page Header with Back Button -->

    @if(auth()->user()->role == 1 ||auth()->user()->role == 2 )
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Task List
        </a>
        <h4 class="mb-0 text-secondary fw-bold">Task Details</h4>
        <div style="width: 135px"></div> <!-- Spacer for alignment -->
    </div>
    @else
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('my.tasks') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Task List
        </a>
        <h4 class="mb-0 text-secondary fw-bold">Task Details</h4>
        <div style="width: 135px"></div> <!-- Spacer for alignment -->
    </div>

    @endif

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h2 class="h4 mb-0 text-center font-weight-bold">{{ $task->task_name }}</h2>
        </div>

        <div class="card-body p-0">
            <!-- Task Summary Panel -->
            <div class="p-4 border-bottom">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-3">
                            @if ($task->status == 0)
                                <span class="badge bg-danger px-3 py-2 me-2">Pending</span>
                            @elseif($task->status == 1)
                                <span class="badge bg-warning px-3 py-2 me-2">Processing</span>
                            @else
                                <span class="badge bg-success px-3 py-2 me-2">Completed</span>
                            @endif
                            <h6 class="text-muted mb-0">
                                <i class="far fa-calendar-alt me-1"></i>
                                Due: {{ $task->dateLimit ? \Carbon\Carbon::parse($task->dateLimit)->format('d M, Y') : 'No deadline' }}
                            </h6>
                        </div>

                        <div class="card bg-light border-0 p-3 mb-3">
                            <h6 class="text-primary mb-2"><i class="fas fa-tasks me-2"></i>Description</h6>
                            <p class="lead mb-0">{{ $task->task_description }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border shadow-sm">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 text-secondary"><i class="fas fa-user-check me-2"></i>Assignment Info</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle me-2 bg-primary text-white">
                                        {{ substr($task->user->name ?? 'UA', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $task->user->name ?? 'Unassigned' }}</p>
                                        <small class="text-muted">Assigneed</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2 bg-info text-white">
                                        {{ substr($task->creator->name ?? 'UN', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $task->creator->name ?? 'Unknown' }}</p>
                                        <small class="text-muted">Created by</small>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted d-block">Date Created:</small>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($task->created_at)->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Timeline Panel -->
            <div class="p-4">
                <div class="card border shadow-sm">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-secondary"><i class="fas fa-history me-2"></i>Task Timeline</h6>
                        <span class="badge bg-primary">{{ $task->transfers->count() }} Transfers</span>
                    </div>
                    <div class="card-body">
                        @if($task->transfers->isEmpty())
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>No task transfer history available.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover border">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Transferred From</th>
                                            <th scope="col">Transferred To</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Remark</th>
                                            <th scope="col">Transfer Date</th>
                                            <th scope="col">Transferred By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($task->transfers as $transfer)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle avatar-sm me-2 bg-secondary text-white">
                                                            {{ substr($transfer->oldUser->name ?? 'UN', 0, 1) }}
                                                        </div>
                                                        {{ $transfer->oldUser->name ?? 'Unknown' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle avatar-sm me-2 bg-secondary text-white">
                                                            {{ substr($transfer->newUser->name ?? 'UN', 0, 1) }}
                                                        </div>
                                                        {{ $transfer->newUser->name ?? 'Unknown' }}
                                                    </div>
                                                </td>
                                                <td>{{ $transfer->task_description }}</td>
                                                <td>{{ $transfer->task_remark }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('d M, Y') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle avatar-sm me-2 bg-secondary text-white">
                                                            {{ substr($transfer->transferredBy->name ?? 'UN', 0, 1) }}
                                                        </div>
                                                        {{ $transfer->transferredBy->name ?? 'Unknown' }}
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
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{-- <button type="button" class="btn btn-outline-info me-2" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Print Details
            </button> --}}
            {{-- <div class="btn-group" role="group">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                @if($task->status != 2)
                    <a href="{{ route('tasks.complete', $task->id) }}" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Complete
                    </a>
                @endif
            </div> --}}
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #3a57e8, #2b48c5);
}

.avatar-circle {
    width: 40px;
    height: 40px;
    background-color: #eee;
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
    overflow: hidden;
}

.card-header {
    border-bottom: 0;
}

.shadow {
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.08) !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05) !important;
}

/* Table Styling */
.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.table tbody td {
    vertical-align: middle;
    padding: 0.75rem 1rem;
}

/* Badge Styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Improved Button Styling */
.btn {
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.btn-primary {
    background-color: #3a57e8;
    border-color: #3a57e8;
}

.btn-primary:hover {
    background-color: #2b48c5;
    border-color: #2b48c5;
}

.btn-success {
    background-color: #1aa053;
    border-color: #1aa053;
}

.btn-success:hover {
    background-color: #158544;
    border-color: #158544;
}

.btn-outline-primary {
    color: #3a57e8;
    border-color: #3a57e8;
}

.btn-outline-primary:hover {
    background-color: #3a57e8;
    color: white;
}

/* Print styles */
@media print {
    .btn, .card-footer {
        display: none;
    }

    .container {
        width: 100%;
        max-width: none;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
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
