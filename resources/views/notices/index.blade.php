@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Notice Management</h6>
                @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                    <a href="{{ route('notice.create') }}" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-bullhorn"></i> Create Notice
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>SI</th>
                                <th>Title</th>
                                <th>Notice Type</th>
                                <th>Notice For</th>
                                <th>Publish Date</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($notices->count() > 0)
                                @foreach ($notices as $notice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $notice->title ?? '' }}</td>
                                        <td>{{ config('static_array.notice_type')[$notice->notice_type] }}</td>
                                        <td>
                                            @php
                                                $noticeForNames = array_map(function ($value) use ($user_types) {
                                                    return $user_types[$value] ?? '';
                                                }, json_decode($notice->notice_for));
                                            @endphp
                                            {!! implode(
                                                array_map(function ($name) {
                                                    return '<span class="badge bg-primary me-1">' . e($name) . '</span>';
                                                }, $noticeForNames),
                                            ) !!}
                                        </td>

                                        <td>{{ $notice->publish_date ?? '' }}</td>
                                        <td>{{ $notice->expire_date ?? '' }}</td>

                                        <td class="text-center">
                                            @if ($notice->is_active == 1)
                                                <i class="text-success fas fa-check-circle" title="Active"></i>
                                            @else
                                                <i class="text-danger fas fa-times-circle" title="Inactive"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->user()->role == 1)
                                                <a href="{{route('notice.edit', $notice->id)}}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @endif
                                                <a href="{{route('notice.view', $notice->id)}}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                {{ $notices->links() }}
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
        .form-select,
        .form-control {
            border-radius: 0.25rem;
            font-size: 0.875rem;
            min-height: calc(1.5em + 0.5rem + 2px);
        }

        /* Text handling */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-break {
            word-break: break-word !important;
            word-wrap: break-word !important;
        }

        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        /* Responsive Adjustments */
        @media (max-width: 767.98px) {

            .table th,
            .table td {
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
@endsection
