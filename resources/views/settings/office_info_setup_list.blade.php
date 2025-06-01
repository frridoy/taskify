@extends('admin.layouts.app')
@section('content')
<div class="container py-4">
    <div class="office-info-wrapper card border-0 shadow-sm">
        <!-- Simple Header Section -->
        <div class="card-header bg-primary text-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-building me-2"></i>
                    <h1 class="h5 mb-0 fw-semibold">Office Information</h1>
                </div>
                @if(auth()->user()->role == 1)
                <a href="{{ route('office_info_setup.edit', $office_info->id ?? '') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                @endif
            </div>
        </div>

        <div class="card-body p-3">
            <!-- Company Profile Section -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-2 col-sm-3 mb-3 mb-sm-0">
                    @if($office_info->company_logo)
                        <img src="{{ asset('office/'.$office_info->company_logo) }}" alt="Company Logo" class="img-fluid rounded" style="max-width: 100%; max-height: 100px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="fas fa-building text-secondary" style="font-size: 2rem;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-10 col-sm-9">
                    <h2 class="h4 mb-1 fw-semibold text-primary">{{ $office_info->company_name ?? 'Company Name' }}</h2>
                    <p class="text-muted small mb-1">
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $office_info->company_location ?? 'Not Available' }}
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-clock me-1"></i> Last updated: {{ $office_info->updated_at ? $office_info->updated_at->format('M d, Y \a\t h:i A') : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Description Section -->
            @if($office_info->company_description)
                <div class="mb-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">About Company</h3>
                            <p class="mb-0">{{ $office_info->company_description }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="mb-4">
                <h3 class="h6 fw-semibold mb-3 border-bottom pb-2">Contact Information</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 text-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Email</div>
                                <div class="fw-semibold">{{ $office_info->company_email ?? 'Not Available' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 text-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Phone</div>
                                <div class="fw-semibold">{{ $office_info->company_phone ?? 'Not Available' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            @if($office_info->company_facebook || $office_info->company_twitter || $office_info->company_linkedin)
                <div class="mb-4">
                    <h3 class="h6 fw-semibold mb-3 border-bottom pb-2">Social Media</h3>
                    <div class="d-flex gap-3">
                        @if($office_info->company_facebook)
                            <a href="{{ $office_info->company_facebook }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook me-1"></i> Facebook
                            </a>
                        @endif
                        @if($office_info->company_twitter)
                            <a href="{{ $office_info->company_twitter }}" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i> Twitter
                            </a>
                        @endif
                        @if($office_info->company_linkedin)
                            <a href="{{ $office_info->company_linkedin }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-linkedin me-1"></i> LinkedIn
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Office Schedule -->
            <div class="mb-4">
                <h3 class="h6 fw-semibold mb-3 border-bottom pb-2">Office Schedule</h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <div class="text-center mb-2">
                                    <i class="fas fa-sign-in-alt text-primary fs-4"></i>
                                </div>
                                <div class="text-muted small text-center">Check-in Time</div>
                                <div class="text-center fw-bold fs-5 mt-1">{{ $office_info->check_in_time ?? 'Not Set' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <div class="text-center mb-2">
                                    <i class="fas fa-sign-out-alt text-primary fs-4"></i>
                                </div>
                                <div class="text-muted small text-center">Check-out Time</div>
                                <div class="text-center fw-bold fs-5 mt-1">{{ $office_info->check_out_time ?? 'Not Set' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <div class="text-center mb-2">
                                    <i class="fas fa-umbrella-beach text-primary fs-4"></i>
                                </div>
                                <div class="text-muted small text-center">Annual Leave Days</div>
                                <div class="text-center fw-bold fs-5 mt-1">{{ $office_info->total_leave_days_for_employee_in_year ?? 'Not Set' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Working Days -->
            <div class="mb-4">
                <h3 class="h6 fw-semibold mb-3 border-bottom pb-2">Working Days</h3>
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <div class="row g-2">
                            @php
                                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                $workingDays = explode(',', $office_info->working_days ?? '1,2,3,4,5');
                            @endphp

                            @foreach($days as $index => $day)
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="d-flex align-items-center p-2 {{ in_array($index + 1, $workingDays) ? 'text-primary' : 'text-muted' }}">
                                        <i class="fas {{ in_array($index + 1, $workingDays) ? 'fa-check-circle me-2' : 'fa-times-circle me-2' }}"></i>
                                        {{ $day }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Footer -->
        {{-- <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-end">
                <a href="{{ route('superAdmin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div> --}}
    </div>
</div>

<style>
    /* Simple, minimal styles */
    .card {
        transition: all 0.2s ease;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
    }

    /* Clean, simple layout */
    .container {
        max-width: 1140px;
    }

    /* Simple, flat design for cards */
    .card {
        border-radius: 6px;
    }

    .card-header {
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }
</style>
@endsection
