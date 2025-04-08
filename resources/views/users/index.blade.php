@extends('setup.master')
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
                                            {{ $user->role == 2 ? 'Manager' : 'Employee' }}
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






{{-- @extends('setup.master')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Card -->
        <div class="bg-indigo-600 text-white p-2 d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-users me-2"></i> User Management</h4>
            <a href="{{ route('users.create') }}" class="btn btn-light">
                <i class="fas fa-plus-circle me-1"></i>Add New User
            </a>
        </div>

        <!-- Filter Controls -->
        <div class="bg-white py-4 px-3">
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search users...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="roleFilter" class="form-select">
                        <option value="">Role</option>
                        <option value="Manager">Manager</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="">Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="resetFilters" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="bg-white">
            <div class="table-responsive">
                <table id="userTable" class="table table-hover mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 5%" class="py-0">
                                <a href="#" class="sort-link text-white" data-column="id">
                                    <i class="fas fa-sort text-light me-1"></i> ID
                                </a>
                            </th>
                            <th style="width: 30%" class="py-0">
                                <a href="#" class="sort-link text-white" data-column="name">
                                    <i class="fas fa-sort text-light me-1"></i> Name
                                </a>
                            </th>
                            <th style="width: 25%" class="py-0">
                                <a href="#" class="sort-link text-white" data-column="email">
                                    <i class="fas fa-sort text-light me-1"></i> Email
                                </a>
                            </th>
                            <th style="width: 10%" class="py-3 text-white">Role</th>
                            <th style="width: 15%" class="py-3 text-white">Contact</th>
                            <th style="width: 10%" class="py-3 text-white">Status</th>
                            <th style="width: 15%" class="py-3 text-end text-white">Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($users as $user)
                            <tr class="user-row"
                                data-name="{{ strtolower($user->name) }}"
                                data-email="{{ strtolower($user->email) }}"
                                data-role="{{ $user->role == 2 ? 'Manager' : 'Employee' }}"
                                data-status="{{ $user->status == 1 ? 'Active' : 'Inactive' }}">
                                <td class="align-middle">{{ $user->id }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @if ($user->profile_photo)
                                            <div class="flex-shrink-0">
                                                <img
                                                    src="{{ asset('profile_photos/' . $user->profile_photo) }}"
                                                    alt="{{ $user->name }}"
                                                    class="rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                >
                                            </div>
                                        @else
                                            <div
                                                class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 40px; height: 40px; font-size: 16px;"
                                            >
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">User ID: #{{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-secondary text-white px-3 py-2">
                                        {{ $user->role == 2 ? 'Manager' : 'Employee' }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-muted me-2"></i>
                                        {{ $user->phone_no }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }} text-white px-3 py-2">
                                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-user" data-id="{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <div id="userCounter" class="text-muted">
                    Showing <span id="visibleCount">{{ count($users) }}</span> users
                </div>
                <div>
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link" href="#" id="prevPage">Previous</a>
                        </li>
                        <li class="page-item" id="page1"><a class="page-link" href="#">1</a></li>
                        <li class="page-item" id="page2"><a class="page-link" href="#">2</a></li>
                        <li class="page-item" id="page3"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" id="nextPage">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .bg-indigo-600 {
            background-color: #4f46e5;
        }

        .table > :not(caption) > * > * {
            padding: 1rem;
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
        }

        .sort-link:hover {
            color: #4f46e5 !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.04);
        }

        .page-item.active .page-link {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .page-link {
            color: #4f46e5;
        }

        .page-link:hover {
            color: #4338ca;
        }

        #resetFilters:hover {
            background-color: #e2e2e2;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            const ITEMS_PER_PAGE = 5;
            let currentPage = 1;
            let filteredRows = [];

            // Initialize the table
            initializeTable();

            // Search functionality
            $("#searchInput").on("keyup", function() {
                filterTable();
            });

            // Role filter
            $("#roleFilter").on("change", function() {
                filterTable();
            });

            // Status filter
            $("#statusFilter").on("change", function() {
                filterTable();
            });

            // Reset filters
            $("#resetFilters").on("click", function() {
                $("#searchInput").val("");
                $("#roleFilter").val("");
                $("#statusFilter").val("");
                filterTable();
            });

            // Pagination controls
            $("#prevPage").on("click", function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                    showCurrentPageItems();
                }
            });

            $("#nextPage").on("click", function(e) {
                e.preventDefault();
                const totalPages = Math.ceil(filteredRows.length / ITEMS_PER_PAGE);
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                    showCurrentPageItems();
                }
            });

            $(".pagination .page-item:not(:first-child):not(:last-child)").on("click", function(e) {
                e.preventDefault();
                currentPage = parseInt($(this).text());
                updatePagination();
                showCurrentPageItems();
            });

            // Sorting functionality
            $(".sort-link").on("click", function(e) {
                e.preventDefault();
                var column = $(this).data("column");
                sortTable(column);
            });

            // Initialize table and pagination
            function initializeTable() {
                filterTable();
                updatePagination();
                showCurrentPageItems();
            }

            // Filter table based on search, role, and status
            function filterTable() {
                const searchValue = $("#searchInput").val().toLowerCase();
                const roleValue = $("#roleFilter").val();
                const statusValue = $("#statusFilter").val();

                filteredRows = [];

                $(".user-row").each(function() {
                    const $row = $(this);
                    const nameMatch = $row.data("name").indexOf(searchValue) > -1;
                    const emailMatch = $row.data("email").indexOf(searchValue) > -1;
                    const searchMatch = nameMatch || emailMatch;

                    const roleMatch = roleValue === "" || $row.data("role") === roleValue;
                    const statusMatch = statusValue === "" || $row.data("status") === statusValue;

                    if (searchMatch && roleMatch && statusMatch) {
                        filteredRows.push($row);
                        $row.removeClass("d-none");
                    } else {
                        $row.addClass("d-none");
                    }
                });

                // Reset to first page and update
                currentPage = 1;
                updateUserCounter();
                updatePagination();
                showCurrentPageItems();
            }

            // Update the user counter
            function updateUserCounter() {
                $("#visibleCount").text(filteredRows.length);
            }

            // Update pagination controls
            function updatePagination() {
                const totalPages = Math.max(1, Math.ceil(filteredRows.length / ITEMS_PER_PAGE));

                // Always show 3 pages
                let startPage = currentPage - 1;
                if (startPage < 1) startPage = 1;
                if (startPage > totalPages - 2) startPage = Math.max(1, totalPages - 2);

                // Update page numbers
                for (let i = 1; i <= 3; i++) {
                    const pageNum = startPage + i - 1;
                    const $pageItem = $(`#page${i}`);

                    if (pageNum <= totalPages) {
                        $pageItem.show();
                        $pageItem.find(".page-link").text(pageNum);

                        if (pageNum === currentPage) {
                            $pageItem.addClass("active");
                        } else {
                            $pageItem.removeClass("active");
                        }

                        // Set click handler for page number
                        $pageItem.off("click").on("click", function(e) {
                            e.preventDefault();
                            currentPage = pageNum;
                            updatePagination();
                            showCurrentPageItems();
                        });
                    } else {
                        $pageItem.hide();
                    }
                }

                // Update Previous/Next buttons
                if (currentPage === 1) {
                    $("#prevPage").parent().addClass("disabled");
                } else {
                    $("#prevPage").parent().removeClass("disabled");
                }

                if (currentPage >= totalPages) {
                    $("#nextPage").parent().addClass("disabled");
                } else {
                    $("#nextPage").parent().removeClass("disabled");
                }
            }

            // Show items for the current page
            function showCurrentPageItems() {
                const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
                const endIndex = startIndex + ITEMS_PER_PAGE;

                // Hide all rows first
                $(".user-row").addClass("d-none");

                // Show only the current page's rows
                for (let i = startIndex; i < endIndex && i < filteredRows.length; i++) {
                    filteredRows[i].removeClass("d-none");
                }
            }

            // Sort table by column
            function sortTable(column) {
                filteredRows.sort(function(a, b) {
                    let aValue, bValue;

                    if (column === "id") {
                        aValue = parseInt(a.find("td:first").text());
                        bValue = parseInt(b.find("td:first").text());
                    } else if (column === "name") {
                        aValue = a.data("name");
                        bValue = b.data("name");
                    } else if (column === "email") {
                        aValue = a.data("email");
                        bValue = b.data("email");
                    }

                    return aValue > bValue ? 1 : -1;
                });

                showCurrentPageItems();
            }

            // Delete user confirmation
            $('.delete-user').on('click', function() {
                const userId = $(this).data('id');

                if (confirm('Are you sure you want to delete this user?')) {
                    // Implement delete logic here
                    console.log("Deleting user ID: " + userId);
                }
            });
        });
    </script>
@endpush --}}
