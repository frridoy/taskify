@extends('setup.layout')

@section('content')
    <div class="container">
        <h2>User List</h2>
        <table id="userTable" class="display table table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->role == 2 ? 'HR' : 'Employee' }}
                        </td>
                        <td>{{ $user->phone_no }}</td>
                        <td>
                            {{ $user->status == 1 ? 'Active' : 'Inactive' }}

                        </td>
                        <td class="text-center">
                            @if ($user->profile_photo)
                                <img
                                    src="{{ asset('profile_photos/' . $user->profile_photo) }}"
                                    alt="Profile Photo"
                                    class="rounded-circle"
                                    style="width: 50px; height: 50px; object-fit: cover;"
                                />
                            @else
                                <div
                                    class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;"
                                >
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
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
            $('#userTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
@endpush
