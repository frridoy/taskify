@extends('admin.layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task Search Engine</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .search-results {
                margin-top: 20px;
            }

            .status-pending {
                color: #ffc107;
                font-weight: bold;
            }

            .status-completed {
                color: #28a745;
                font-weight: bold;
            }

            .status-in-progress {
                color: #17a2b8;
                font-weight: bold;
            }

            .table-responsive {
                overflow-x: auto;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h5>Search Filters</h5>
                </div>
                <div class="card-body">
                    <form id="searchForm">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">Assigned User</label>
                                    <select class="form-select" name="user_name" id="user_name">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="created_by" class="form-label">Created By</label>
                                    <select class="form-select" name="created_by" id="created_by">
                                        <option value="">Select Creator</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">All Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">In Progress</option>
                                        <option value="2">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <button type="reset" id="resetBtn" class="btn btn-outline-secondary">Reset</button>
                    </form>
                </div>
            </div>

            <div id="searchResults" class="search-results">
                <div class="alert alert-info">
                    Enter search criteria and click "Search" to find tasks.
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Search form submission
                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();
                    searchTasks();
                });

                $('#resetBtn').on('click', function(e) {
                    $('#searchForm')[0].reset();

                    $('#searchResults').html(
                        '<div class="alert alert-info">Enter search criteria and click "Search" to find tasks.</div>'
                    );

                    e.preventDefault();
                });
            });

            function searchTasks() {
                const formData = $('#searchForm').serialize();

                $.ajax({
                    url: "{{ route('search.engine.result') }}",
                    type: "GET",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $('#searchResults').html(
                            '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                    },
                    success: function(response) {
                        displayResults(response);
                    },
                    error: function(xhr) {
                        $('#searchResults').html(
                            '<div class="alert alert-danger">Error fetching results. Please try again.</div>'
                        );
                        console.error(xhr.responseText);
                    }
                });
            }

            function displayResults(tasks) {
                if (tasks.length === 0) {
                    $('#searchResults').html('<div class="alert alert-danger">No tasks found matching your criteria.</div>');
                    return;
                }

                let html = `<div class="alert alert-success"><strong>Total Results:</strong> ${tasks.length}</div>`;
                html += `
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Task Name</th>
                                    <th>Assigned To</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                tasks.forEach(function(task) {
                    let statusClass = '';
                    switch (parseInt(task.status)) {
                        case 0:
                            statusClass = 'status-pending';
                            break;
                        case 1:
                            statusClass = 'status-in-progress';
                            break;
                        case 2:
                            statusClass = 'status-completed';
                            break;
                    }

                    const dueDate = task.dateLimit ? new Date(task.dateLimit).toLocaleDateString() : 'Not set';
                    const createdAt = new Date(task.created_at).toLocaleString();
                    const description = task.description ? task.description : 'N/A';

                    html += `
                        <tr>
                            <td>${escapeHtml(task.task_name)}</td>
                            <td>${escapeHtml(task.assigned_user_name)}</td>
                            <td>${escapeHtml(task.created_by_name)}</td>
                            <td><span class="${statusClass}">${task.status_text}</span></td>
                            <td>${escapeHtml(description)}</td>
                            <td>${dueDate}</td>
                            <td>${createdAt}</td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                $('#searchResults').html(html);
            }

            function escapeHtml(unsafe) {
                if (!unsafe) return unsafe;
                return unsafe.toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }
        </script>
    </body>

    </html>
@endsection
