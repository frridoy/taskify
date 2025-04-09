@extends('setup.master')
@section('content')
<div class="container py-4">
    <div class="office-info-wrapper card border-0 shadow-sm">
        <!-- Header Section -->
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-semibold text-primary">
                    <i class="fas fa-building me-2"></i> Office Information
                </h1>
                <a href="{{ route('office_info_setup.edit', $office_info->id ?? '') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Company Profile Section -->
            <div class="company-profile mb-4">
                <div class="d-flex align-items-center">
                    <div class="company-logo-container me-4">
                        @if($office_info->company_logo)
                            <img src="{{ asset('office/'.$office_info->company_logo) }}" alt="Company Logo" class="img-fluid rounded border" style="max-width: 100px; max-height: 100px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="fas fa-building text-secondary" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="company-details">
                        <h2 class="h4 mb-1 fw-semibold">{{ $office_info->company_name ?? 'Company Name' }}</h2>
                        <span class="text-muted small">
                            <i class="fas fa-clock me-1"></i>
                            Last updated: {{ $office_info->updated_at ? $office_info->updated_at->format('M d, Y \a\t h:i A') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Key Information Grid -->
            <div class="info-grid row g-3 mb-4">
                <div class="col-md-6">
                    <div class="info-item card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="info-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-envelope fs-5"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label text-muted small">Email</div>
                                    <div class="info-value fw-semibold">
                                        {{ $office_info->company_email ?? 'Not Available' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-item card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="info-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-phone fs-5"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label text-muted small">Phone</div>
                                    <div class="info-value fw-semibold">
                                        {{ $office_info->company_phone ?? 'Not Available' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-item card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="info-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-globe fs-5"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label text-muted small">Website</div>
                                    <div class="info-value fw-semibold">
                                        @if($office_info->company_website)
                                            <a href="{{ $office_info->company_website }}" target="_blank" class="text-decoration-none">
                                                {{ $office_info->company_website }}
                                                <i class="fas fa-external-link-alt ms-1 small"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">Not Available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-item card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="info-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-map-marker-alt fs-5"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label text-muted small">Location</div>
                                    <div class="info-value fw-semibold">
                                        {{ $office_info->company_location ?? 'Not Available' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="info-section card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <div class="d-flex align-items-center">
                        <div class="section-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                            <i class="fas fa-address-card"></i>
                        </div>
                        <h3 class="section-title h6 mb-0 fw-semibold">Address</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-value">
                        @if($office_info->company_address)
                            {{ $office_info->company_address }}
                        @else
                            <span class="text-muted">Not Available</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Office Hours Section -->
            <div class="info-section card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex align-items-center">
                        <div class="section-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                            <i class="fas fa-business-time"></i>
                        </div>
                        <h3 class="section-title h6 mb-0 fw-semibold">Office Hours</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="schedule-card card h-100 border-0 bg-light">
                                <div class="card-body text-center py-4">
                                    <div class="schedule-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                                        <i class="fas fa-sign-in-alt fs-4"></i>
                                    </div>
                                    <div class="info-label text-muted small mb-1">Check-in Time</div>
                                    <div class="schedule-time h5 fw-bold text-primary">
                                        {{ $office_info->check_in_time ?? 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="schedule-card card h-100 border-0 bg-light">
                                <div class="card-body text-center py-4">
                                    <div class="schedule-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                                        <i class="fas fa-sign-out-alt fs-4"></i>
                                    </div>
                                    <div class="info-label text-muted small mb-1">Check-out Time</div>
                                    <div class="schedule-time h5 fw-bold text-primary">
                                        {{ $office_info->check_out_time ?? 'Not Set' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
    </div>
</div>

<style>
    .company-logo-container img {
        object-fit: contain;
        width: 100%;
        height: 100%;
    }

    .info-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-section {
        transition: all 0.3s ease;
    }

    .info-section:hover {
        transform: translateY(-2px);
    }

    .schedule-card {
        transition: all 0.3s ease;
    }

    .schedule-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection
