@extends('setup.layout')
@section('content')
<div class="container">
    <h2 class="text-center mb-1">All Tasks</h2>

    @if(Auth::user()->role == 1 || Auth::user()->role == 2)
        <a href="{{ route('tasks.assign') }}" class="btn btn-primary mb-3">
            <i class="fas fa-tasks"></i> Create Task
        </a>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>SI</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Assigned To</th>
                    <th>Date Limit</th>
                    <th>Status</th>
                    <th>Created At</th>
                    @if(auth()->user()->role == 3)
                        <th>Receive</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->task_description }}</td>
                        <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                        <td>{{ $task->dateLimit ? \Carbon\Carbon::parse($task->dateLimit)->format('d M, Y') : 'N/A' }}</td>

                        <td>
                            @if($task->status == 0)
                                <span class="badge bg-danger">Pending ....</span>
                            @elseif($task->status == 1)
                                <span class="badge bg-warning">Processing</span>
                            @else
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d M, Y') }}</td>
                        @if(auth()->user()->role == 3 && $task->status == 0)
                            <td>
                                <form action="{{ route('task.receive', $task->id) }}" method="POST" class="d-inline" id="receive-form-{{ $task->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to receive this task?')">
                                        <i class="fas fa-check"></i> Receive
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .table th, .table td {
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
