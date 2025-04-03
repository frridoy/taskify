@extends('setup.layout')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Team Details: {{ $team->team_name }}</h2>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <!-- Team Information -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h4>Team Number: {{ $team->team_number }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h5>Total Members: {{ $members->count() }}</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>Team Leader:
                                @php
                                    $teamLeader = $members->where('is_team_leader', 1)->first();
                                    $leaderName = $teamLeader ? $teamLeader->employee->name : 'Not assigned';
                                @endphp
                                {{ $leaderName }}
                            </h5>
                        </div>
                    </div>

                <!-- Team Members Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Member Name</th>
                                <th>Member ID</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="20%">Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->employee->name }}</td>
                                    <td>{{ $member->employee->id }}</td>
                                    <td>
                                        @if($member->employee->role == 2)
                                            <span class="text-primary fw-bold">
                                                <i class="fas fa-user-tie me-1"></i> HR Manager
                                            </span>
                                        @else
                                            <span class="text-secondary fw-bold">
                                                <span><i class="fas fa-user"></i></span> Sales Person
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($member->employee->status == 1)
                                            <span class="text-success fw-bold">
                                                <i class="fas fa-check-circle me-1"></i>
                                            </span>
                                        @else
                                            <span class="text-danger fw-bold">
                                                <i class="fas fa-times-circle me-1"></i>
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($member->is_team_leader)
                                            <span><i class="fas fa-crown"></i></span>
                                        @else
                                            <span><i class="fas fa-user"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Back to Team List button -->
                <a href="{{ route('team.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Back to Team List
                </a>
            </div>
        </div>
    </div>
@endsection
