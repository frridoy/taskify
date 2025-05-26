@extends('setup.master')
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

            .task-card {
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 15px;
                margin-bottom: 15px;
                background-color: #f9f9f9;
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
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="mb-4">Task Search Engine</h1>

            <div class="card">
                <div class="card-header">
                    <h5>Search Filters</h5>
                </div>
                <div class="card-body">
                    <form id="searchForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">User Name</label>
                                    <select class="form-select" name="user_name" id="user_name">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
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
                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();
                    searchTasks();
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
                            '<div class="alert alert-danger">Error fetching results. Please try again.</div>');
                    }
                });
            }

            function displayResults(tasks) {
                if (tasks.length === 0) {
                    $('#searchResults').html('<div class="alert alert-warning">No tasks found matching your criteria.</div>');
                    return;
                }

                let html = '<div class="row">';

                tasks.forEach(function(task) {
                    let statusClass = '';
                    switch (task.status) {
                        case '0':
                            statusClass = 'status-pending';
                            break;
                        case '2':
                            statusClass = 'status-completed';
                            break;
                        case '1':
                            statusClass = 'status-in-progress';
                            break;
                    }

                    html += `
                    <div class="col-md-6">
                        <div class="task-card">
                            <h5>${task.title}</h5>
                            <p><strong>Assigned to:</strong> ${task.user_name}</p>
                            <p><strong>Status:</strong> <span class="${statusClass}">${task.status}</span></p>
                            <p><strong>Description:</strong> ${task.description || 'N/A'}</p>
                            <p><strong>Due Date:</strong> ${task.due_date ? new Date(task.due_date).toLocaleDateString() : 'Not set'}</p>
                            <p><strong>Created At:</strong> ${new Date(task.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                `;
                });

                html += '</div>';
                $('#searchResults').html(html);
            }
        </script>
    </body>

    </html>
@endsection



