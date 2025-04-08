@extends('setup.master')
@section('content')
<div class="container">
    <h1>Attendance List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->user_name}}</td>
                    <td>{{ $attendance->created_at}}</td>
                    <td>{{ $attendance->location == '23.7783664,90.4031032' ? 'Present' : 'Absent' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
