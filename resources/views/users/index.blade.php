@extends('setup.layout')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">User Management</h4>
                <a href="{{ route('users.create') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>Add New User
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-borderless">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center align-middle">
                                    <i class="fas fa-hashtag me-2"></i>
                                    <span>ID</span>
                                </th>
                                <th class="align-middle">
                                    <i class="fas fa-user me-2"></i>
                                    <span>Full Name</span>
                                </th>
                                <th class="align-middle">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span>Email</span>
                                </th>
                                <th class="align-middle">
                                    <i class="fas fa-briefcase me-2"></i>
                                    <span>Role</span>
                                </th>
                                <th class="align-middle">
                                    <i class="fas fa-phone me-2"></i>
                                    <span>Contact</span>
                                </th>
                                <th class="text-center align-middle">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Status</span>
                                </th>
                                <th class="text-center align-middle">
                                    <i class="fas fa-image me-2"></i>
                                    <span>Profile</span>
                                </th>
                                <th class="text-center align-middle">
                                    <i class="fas fa-cogs me-2"></i>
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            @if ($user->profile_photo)
                                                <img
                                                    src="{{ asset('profile_photos/' . $user->profile_photo) }}"
                                                    alt="{{ $user->name }}"
                                                    class="rounded-circle me-3 shadow-sm"
                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                >
                                            @else
                                                <div
                                                    class="rounded-circle me-3 bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 40px; height: 40px;"
                                                >
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ $user->email }}</td>
                                    <td class="align-middle">
                                        <span class="badge {{ $user->role == 2 ? 'bg-primary' : 'bg-secondary' }} rounded-pill">
                                            {{ $user->role == 2 ? 'HR Manager' : 'Employee' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ $user->phone_no }}</td>
                                    <td class="text-center align-middle">
                                        <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($user->profile_photo)
                                            <img
                                                src="{{ asset('profile_photos/' . $user->profile_photo) }}"
                                                alt="Profile Photo"
                                                class="rounded-circle shadow-sm"
                                                style="width: 50px; height: 50px; object-fit: cover;"
                                            />
                                        @else
                                            <div
                                                class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 50px; height: 50px;"
                                            >
                                                N/A
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <a
                                                href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-outline-primary btn-sm"
                                                title="Edit User"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button
                                                class="btn btn-outline-danger btn-sm delete-user"
                                                data-id="{{ $user->id }}"
                                                title="Delete User"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        #userTable thead th {
            vertical-align: middle !important;
            white-space: nowrap;
        }
        #userTable th, #userTable td {
            padding: 12px 15px !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                columnDefs: [
                    { orderable: false, targets: [6, 7] }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search users..."
                },
                drawCallback: function() {
                    // Add tooltip to table elements
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('.delete-user').on('click', function() {
                const userId = $(this).data('id');
                if(confirm('Are you sure you want to delete this user?')) {
                    // Implement delete logic
                }
            });
        });
    </script>
@endpush
