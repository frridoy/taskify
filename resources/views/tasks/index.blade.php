@extends('setup.master')
@section('content')
    <div class="container">

        <h2 class="text-center mb-1">{{ $list_title }}</h2>

        @if (Auth::user()->role == 1 || Auth::user()->role == 2)
            <a href="{{ route('tasks.assign') }}" class="btn btn-primary mb-3">
                <i class="fas fa-tasks"></i> Create Task
            </a>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->task_description }}</td>
                            <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                            <td>{{ $task->creator->name ?? 'Unknown' }}</td>
                            <td>{{ $task->dateLimit ? \Carbon\Carbon::parse($task->dateLimit)->format('d M, Y') : 'N/A' }}
                            </td>
                            <td>
                                @if ($task->status == 0)
                                    <span class="badge bg-danger">Pending ....</span>
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

                            <td lass="text-center">

                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                @if (auth()->user()->role == 3 && $task->status == 0 && $task->user_id == $userId)
                                    <form action="{{ route('task.receive', $task->id) }}" method="POST" class="d-inline"
                                        id="receive-form-{{ $task->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            onclick="return confirm('Are you sure you want to receive this task?')">
                                            <i class="fas fa-clipboard-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if (auth()->user()->role == 3 && $task->status == 1 && $task->user_id == $userId)
                                    <form action="{{ route('task.complete', $task->id) }}" method="POST" class="d-inline"
                                        id="complete-form-{{ $task->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            onclick="return confirm('Are you sure you want to complete this task?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if ((auth()->user()->role == 1 || auth()->user()->role == 2 || $teamLeader) && $task->status != 2)
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#transferModal{{ $task->id }}">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                @else
                                    <span class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                    {{ $tasks->links() }}
                @endif
            </div>
        </div>

        {{-- Transfer Modal --}}
        @foreach ($tasks as $task)
            <div class="modal fade" id="transferModal{{ $task->id }}" tabindex="-1"
                aria-labelledby="transferModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="transferModalLabel">Transfer Task: {{ $task->task_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('tasks.transfer.store', $task->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="new_user_id" class="form-label">Transfer To</label> <span class="text-danger">*</span>
                                    <select name="new_user_id" id="new_user_id" class="form-select" required>
                                        @if (auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 2 || $teamLeader != null))
                                        <option value="">Select</option>
                                            @foreach ($users as $user)
                                                @if ($user->role == 3)
                                                    <option value="{{ $user->id }}">{{$user->id}}-{{ $user->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="task_description" class="form-label">Task Description</label>
                                    <textarea name="task_description" id="task_description" readonly class="form-control" rows="3">{{ $task->task_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="task_remark" class="form-label">Task Remark</label>
                                    <textarea name="task_remark" id="task_remark" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Transfer Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.9em;
            padding: 0.5em 0.75em;
        }

        .btn-sm {
            padding: 0.25em 0.5em;
            font-size: 0.875em;
        }

        .alert {
            margin-top: 1em;
        }
    </style>
@endsection
