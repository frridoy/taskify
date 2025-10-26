@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Job Posts Management</h6>
            <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
                <a href="{{ route('hr.job_posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Job Post
                </a>
            </div>
        </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Filter Section -->
                    <form action="{{ route('hr.job_posts.index') }}" method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-3 mb-2">
                                <label for="title" class="form-label">Job Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="Search by job title"
                                       value="{{ request('title') }}">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control"
                                       placeholder="Filter by location"
                                       value="{{ request('location') }}">
                            </div>
                            <div class="col-md-3 mb-2 d-flex align-items-end">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('hr.job_posts.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="jobPostsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>SI</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Deadline</th>
                                    <th>Required Degrees</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobPosts as $post)
                                    <tr>
                                        <td>{{ $jobPosts->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="text-break" style="max-width: 200px;">
                                                {{ $post->title }}
                                            </div>
                                        </td>
                                        <td>{{ $post->location }}</td>
                                        <td>
                                            <span class="{{ $post->deadline->isPast() ? 'text-danger fw-bold' : '' }}">
                                                {{ $post->deadline->format('d M, Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @foreach($post->degrees as $degree)
                                                <span class="badge bg-info">{{ $degree->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge {{ $post->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $post->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $post->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-center gap-1">
                                                <a href="{{ route('hr.job_posts.show', $post) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('hr.job_posts.edit', $post) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Job Post">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('hr.job_posts.destroy', $post) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Job Post"
                                                            onclick="return confirm('Are you sure you want to delete this job post?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i> No job posts found matching your criteria
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $jobPosts->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    .table th,
    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    /* Table Styling */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Cards and UI Components */
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    /* Button and Badge Styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 600;
    }

    .btn-sm {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
    }

    /* Form Controls */
    .form-select, .form-control {
        border-radius: 0.25rem;
        font-size: 0.875rem;
        min-height: calc(1.5em + 0.5rem + 2px);
    }

    /* Text handling */
    .text-break {
        word-break: break-word !important;
        word-wrap: break-word !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .table th, .table td {
            font-size: 0.75rem;
            padding: 0.3rem;
        }
    }

    /* Utility classes */
    .gap-1 {
        gap: 0.25rem !important;
    }

    .gap-2 {
        gap: 0.5rem !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection
