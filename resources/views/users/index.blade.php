@extends('setup.layout')

@section('content')
<div class="container">
    <h2>User List</h2>
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role == 2 ? 'HR' : 'Employee' }}</td>
                    <td>{{ $user->phone_no }}</td>
                    <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#userTable')) {
            $('#userTable').DataTable();
        }
    });
</script>
@endpush
