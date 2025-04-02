@extends('setup.layout')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Team List</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Team Number</th>
                                <th>Team Name</th>
                                <th>Total Members</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teamSummary as $team)
                                <tr>
                                    <td>{{ $team['team_number'] }}</td>
                                    <td>{{ $team['team_name'] }}</td>
                                    <td>{{ $team['total_members'] }}</td>
                                    <td>
                                        <a href="{{ route('team.view', $team['team_number']) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
