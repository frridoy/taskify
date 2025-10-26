@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">HR Dashboard</h2>

            <div class="row">
                <!-- Degrees Management Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Degrees Management</h5>
                            <p class="card-text">Manage educational degrees for job postings.</p>
                            <a href="{{ route('hr.degrees.index') }}" class="btn btn-primary">Manage Degrees</a>
                        </div>
                    </div>
                </div>

                <!-- Job Posts Management Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Job Posts</h5>
                            <p class="card-text">Create and manage job postings.</p>
                            <a href="#" class="btn btn-primary">Manage Jobs</a>
                        </div>
                    </div>
                </div>

                <!-- Candidates Management Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Candidates</h5>
                            <p class="card-text">View and manage job applications.</p>
                            <a href="#" class="btn btn-primary">View Candidates</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
