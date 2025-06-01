@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Team Management</h6>
                @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                    <a href="{{ route('team.build') }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-user-plus"></i> Team Build
                    </a>
                @endif
            </div>
            <div class="card-body">
                <!-- Filter Section -->
                <form action="{{ route('team.index') }}" method="GET" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label for="team_name" class="form-label">Team Name</label>
                            <select name="team_name" id="team_name" class="form-select select2">
                                <option value="">All Teams</option>
                                @foreach ($teamNames as $name)
                                    <option value="{{ $name }}"
                                        {{ isset($_GET['team_name']) && $_GET['team_name'] == $name ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="user" class="form-label">Users</label>
                            <select name="user_id" id="user_id" class="form-select select2">
                                <option value="">All Users</option>
                                @foreach ($userId as $active_user)
                                    <option value="{{ $active_user->user_id }}"
                                        {{ isset($_GET['user_id']) && $_GET['user_id'] == $active_user->user_id ? 'selected' : '' }}>
                                        {{ $active_user->employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('team.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Table Section -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Team Number</th>
                                <th>Team Name</th>
                                <th>Total Members</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($teamSummaryPaginated->count() > 0)
                                @foreach ($teamSummaryPaginated as $team)
                                    <tr>
                                        <td>{{ $team['team_number'] }}</td>
                                        <td>{{ $team['team_name'] }}</td>
                                        <td>{{ $team['total_members'] }}</td>
                                        <td>
                                            <a href="{{ route('team.view', $team['team_number']) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('team.edit', $team['team_number']) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $teamSummaryPaginated->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
