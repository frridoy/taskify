@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">
        {{-- <h2 class="text-center mb-3">{{ $list_title }}</h2> --}}

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Task Management</h6>
                    <a href="{{ route('tasks.assign') }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-tasks"></i> Create Task
                    </a>
            </div>
            <div class="card-body">
                <!-- Filter Section -->
                <form action="{{ route('my.tasks') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label for="status_filter" class="form-label">Status</label>
                            <select name="status" id="status_filter" class="form-select">
                                <option value="">All Status</option>
                                <option value="0" {{ isset($_GET['status']) && $_GET['status'] == '0' ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ isset($_GET['status']) && $_GET['status'] == '1' ? 'selected' : '' }}>Processing</option>
                                <option value="2" {{ isset($_GET['status']) && $_GET['status'] == '2' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        @if(auth()->user()->role == 1 || auth()->user()->role == 2 ||  $teamLeader ==true)
                        <div class="col-md-3 mb-2">
                            <label for="assigned_to_filter" class="form-label">Assigned To</label>
                            <select name="user_id" id="assigned_to_filter" class="form-select">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    @if ($user->role == 3)
                                        <option value="{{ $user->id }}" {{ isset($_GET['user_id']) && $_GET['user_id'] == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-3 mb-2">
                            <label for="urgency_filter" class="form-label">Task Urgency</label>
                            <select name="urgency" id="urgency_filter" class="form-select">
                                <option value="">All Priorities</option>
                                <option value="emergency" {{ isset($_GET['urgency']) && $_GET['urgency'] == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                <option value="high_priority" {{ isset($_GET['urgency']) && $_GET['urgency'] == 'high_priority' ? 'selected' : '' }}>High Priority</option>
                                <option value="normal_priority" {{ isset($_GET['urgency']) && $_GET['urgency'] == 'normal_priority' ? 'selected' : '' }}>Normal Priority</option>
                                <option value="low_priority" {{ isset($_GET['urgency']) && $_GET['urgency'] == 'low_priority' ? 'selected' : '' }}>Low Priority</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('my.tasks') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tasksTable">
                        <thead class="table-dark">
                            <tr>
                                <th>SI</th>
                                <th>Task Name</th>
                                <th>Description</th>
                                <th>Assigned To</th>
                                <th>Created By</th>
                                <th>Date Limit</th>
                                <th>Status</th>
                                <th>Task Urgency</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <td>{{ $tasks->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="text-break" style="max-width: 150px;">
                                            {{ $task->task_name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $task->task_description }}">
                                            {{ $task->task_description }}
                                        </div>
                                    </td>
                                    <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                                    <td>{{ $task->creator->name ?? 'Unknown' }}</td>
                                    <td>
                                        @if($task->dateLimit)
                                            <span class="{{ \Carbon\Carbon::parse($task->dateLimit)->isPast() && $task->status != 2 ? 'text-danger fw-bold' : '' }}">
                                                {{ \Carbon\Carbon::parse($task->dateLimit)->format('d M, Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($task->status == 0)
                                            <span class="badge bg-danger">Pending</span>
                                        @elseif($task->status == 1)
                                            <span class="badge bg-warning">Processing</span>
                                        @else
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($task->task_urgency == 'emergency')
                                            <span class="fw-bold text-danger">🔴 Emergency</span>
                                        @elseif($task->task_urgency == 'high_priority')
                                            <span class="fw-bold text-warning">🟡 High Priority</span>
                                        @elseif($task->task_urgency == 'normal_priority')
                                            <span class="fw-bold text-success">🟢 Normal Priority</span>
                                        @else
                                            <span class="fw-bold text-secondary">⚪ Low Priority</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if (auth()->user()->role == 3 && $task->status == 0 && $task->user_id == $userId)
                                                <form action="{{ route('task.receive', $task->id) }}" method="POST" class="d-inline" id="receive-form-{{ $task->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Receive Task" onclick="return confirm('Are you sure you want to receive this task?')">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if (auth()->user()->role == 3 && $task->status == 1 && $task->user_id == $userId)
                                                <form action="{{ route('task.complete', $task->id) }}" method="POST" class="d-inline" id="complete-form-{{ $task->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Complete Task" onclick="return confirm('Are you sure you want to complete this task?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if ((auth()->user()->role == 1 || auth()->user()->role == 2 || $teamLeader) && $task->status != 2)
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#transferModal{{ $task->id }}" title="Transfer Task">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>
                                            @elseif ($task->status == 2)
                                                <span class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Task Completed">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i> No tasks found matching your criteria
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    @if (isset($tasks) && $tasks->hasPages())
                        {{ $tasks->appends(request()->all())->links() }}
                    @endif
                </div>
            </div>
        </div>

        {{-- Transfer Modal --}}
        @foreach ($tasks as $task)
            <div class="modal fade" id="transferModal{{ $task->id }}" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title" id="transferModalLabel">Transfer Task: {{ $task->task_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('tasks.transfer.store', $task->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="new_user_id_{{ $task->id }}" class="form-label">Transfer To</label> <span class="text-danger">*</span>
                                    <select name="new_user_id" id="new_user_id_{{ $task->id }}" class="form-select" required>
                                        @if (auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 2 || $teamLeader != null))
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                @if ($user->role == 3)
                                                    <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'disabled' : '' }}>
                                                        {{ $user->name }} {{ $task->user_id == $user->id ? '(Current Assignee)' : '' }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="task_description_{{ $task->id }}" class="form-label">Task Description</label>
                                    <textarea name="task_description" id="task_description_{{ $task->id }}" readonly class="form-control" rows="3">{{ $task->task_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="task_remark_{{ $task->id }}" class="form-label">Task Remark</label>
                                    <textarea name="task_remark" id="task_remark_{{ $task->id }}" class="form-control" rows="3" placeholder="Enter remark for task transfer..."></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning">Transfer Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
        .form-select, .form-control {
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
            .table th, .table td {
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
