@extends('admin.layouts.app')

@section('title', 'View Job Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Job Post Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('hr.job_posts.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('hr.job_posts.edit', $jobPost) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px">Job Title</th>
                                    <td>{{ $jobPost->title }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $jobPost->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $jobPost->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $jobPost->location }}</td>
                                </tr>
                                <tr>
                                    <th>Salary Range</th>
                                    <td>{{ $jobPost->salary_range }}</td>
                                </tr>
                                <tr>
                                    <th>Application Deadline</th>
                                    <td>{{ $jobPost->deadline->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Required Degrees</th>
                                    <td>
                                        @foreach($jobPost->degrees as $degree)
                                            <span class="badge badge-info">{{ $degree->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{!! nl2br(e($jobPost->description)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Requirements</th>
                                    <td>{!! nl2br(e($jobPost->requirements)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $jobPost->created_at->format('F d, Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $jobPost->updated_at->format('F d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
