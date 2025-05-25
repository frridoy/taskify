@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                <a href="{{ route('users.index') }}" class="btn btn-secondary mt-2 mt-md-0">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Profile Photo Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="m-0">Profile Photo</h6>
                            </div>
                            <div class="card-body text-center">
                                @if ($user->profile_photo)
                                    <img src="{{ asset('profile_photos/' . $user->profile_photo) }}" alt="Profile Photo"
                                        class="img-fluid rounded-circle mb-3"
                                        style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-user fa-4x text-muted"></i>
                                    </div>
                                    <p class="text-muted mt-2">No profile photo uploaded</p>
                                @endif
                            </div>
                        </div>

                        <!-- Signature Section -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="m-0">Employee Signature</h6>
                            </div>
                            <div class="card-body text-center">
                                @if ($user->signature)
                                    <img src="{{ asset('employee_signatures/' . $user->signature) }}"
                                        alt="Employee Signature" class="img-fluid mb-3" style="max-height: 100px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="width: 100%; height: 100px; margin: 0 auto;">
                                        <i class="fas fa-signature fa-3x text-muted"></i>
                                    </div>
                                    <p class="text-muted mt-2">No signature uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="m-0">Basic Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Employee Name</th>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>{{ $user->phone_no }}</td>
                                            </tr>
                                            <tr>
                                                <th>Designation</th>
                                                <td>{{ $user->designation ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Basic Salary</th>
                                                <td>{{ $user->basic_salary ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>{{ $user->department ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Role</th>
                                                <td>
                                                    @if ($user->role == 1)
                                                        <span class="badge bg-danger">Admin</span>
                                                    @elseif($user->role == 2)
                                                        <span class="badge bg-primary">Manager</span>
                                                    @elseif($user->role == 3)
                                                        <span class="badge bg-success">Employee</span>
                                                    @else
                                                        <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if ($user->status == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Joining Date</th>
                                                <td>{{ $user->joining_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Leaving Date</th>
                                                <td>{{ $user->resignation_date}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                @if (auth()->user()->role == 1)
                                    <div class="d-flex justify-content-end mt-3">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary me-2">
                                            <i class="fas fa-edit"></i> Edit User
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="card mt-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="m-0">Additional Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Area</th>
                                                <td>{{ $user->per_area ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Thana</th>
                                                <td>{{ $user->pre_thana ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>District</th>
                                                <td>{{ $user->per_district ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td>{{ $user->country ?? 'Bangladeshi' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Postal Code</th>
                                                <td>{{ $user->postal_code ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{ $user->gender == 1 ? 'Male' : 'Female' ?? '' }}</td>
                                            </tr>
                                             <tr>
                                                <th>Date of Birth</th>
                                                <td>{{ $user->dob ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>NID</th>
                                                <td>{{ $user->nid ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Passport</th>
                                                <td>{{ $user->Passport ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Blood Group</th>
                                                <td>{{ $user->blood_group ?? '' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }

        .card-header {
            border-bottom: none;
            padding: 1rem 1.25rem;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.875em;
            font-weight: 600;
            padding: 0.35em 0.65em;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 767.98px) {

            .col-md-4,
            .col-md-8 {
                padding: 0;
            }

            .card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
