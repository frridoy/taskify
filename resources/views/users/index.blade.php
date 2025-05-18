@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">User Management</h6>
                @if (auth()->user()->role == 1)
                    <a href="{{ route('users.create') }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-user-plus"></i> Create User
                    </a>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('users.index') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label for="status_filter" class="form-label">Status</label>
                            <select name="status" id="status_filter" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ isset($status) && $status == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ isset($status) && $status == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="user" class="form-label">Users</label>
                            <select name="id" id="user" class="form-select select2">
                                <option value="">All Users</option>
                                @foreach ($allUsers as $active_user)
                                    <option value="{{ $active_user->id }}"
                                        {{ request()->input('id') == $active_user->id ? 'selected' : '' }}>
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
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>SI</th>
                                <th>Employee Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Designation</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_no }}</td>
                                        <td>{{ $user->designation ?? '' }}</td>
                                        <td class="text-center">
                                            @if ($user->role == 1)
                                                <i class="fas fa-user-shield text-danger" title="Admin"></i> Admin
                                            @elseif($user->role == 2)
                                                <i class="fas fa-user-tie text-primary" title="Manager"></i> Manager
                                            @elseif($user->role == 3)
                                                <i class="fas fa-user text-success" title="Employee"></i> Employee
                                            @else
                                                <i class="fas fa-question-circle text-muted" title="Unknown Role"></i>
                                                Unknown
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($user->status == 1)
                                                <i class="text-success fas fa-check-circle" title="Active"></i>
                                            @else
                                                <i class="text-danger fas fa-times-circle" title="Inactive"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->user()->role == 1)
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('users.view', $user->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#resetPasswordModal{{ $user->id }}">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                            @else
                                                <i class="bi bi-x-circle text-muted"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @include('modals.password-reset')
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
                    @if (isset($users) && $users->hasPages())
                        {{ $users->appends(request()->all())->links() }}
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
