@extends('setup.master')
@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-cog me-2"></i>
                    {{ isset($office_info) ? 'Edit Company Settings' : 'Add Company Settings' }}
                </h4>
                @if(isset($office_info) && $office_info->company_logo)
                    <img src="{{ asset('storage/' . $office_info->company_logo) }}" alt="Company Logo" height="40" class="rounded-circle border border-3 border-white">
                @endif
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ isset($office_info) ? route('office_info_setup.update', $office_info->id) : route('office_info_setup.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="needs-validation"
                  novalidate>
                @csrf
                @if(isset($office_info))
                    @method('PUT')
                @endif

                <!-- Basic Information Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-header d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-light text-primary me-3">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Basic Information</h5>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_name" class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" name="company_name" id="company_name"
                                   class="form-control @error('company_name') is-invalid @enderror"
                                   value="{{ old('company_name', $office_info->company_name ?? '') }}"
                                   placeholder="Enter company name" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_logo" class="form-label fw-semibold">Company Logo</label>
                        <div class="file-upload-wrapper">
                            <div class="input-group">
                                <span class="input-group-text bg-primary-light text-primary">
                                    <i class="fas fa-image"></i>
                                </span>
                                <input type="file" name="company_logo" id="company_logo"
                                       class="form-control @error('company_logo') is-invalid @enderror"
                                       accept="image/*">
                                @error('company_logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if(isset($office_info) && $office_info->company_logo)
                                <div class="mt-3 d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $office_info->company_logo) }}"
                                         alt="Company Logo" height="60" class="img-thumbnail me-3">
                                    <div>
                                        <span class="badge bg-primary">Current Logo</span>
                                        <div class="form-text small">Max 2MB • PNG, JPG, JPEG</div>
                                    </div>
                                </div>
                            @else
                                <div class="form-text small mt-1">Max 2MB • PNG, JPG, JPEG</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Office Hours Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-header d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-light text-primary me-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Office Hours</h5>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="check_in_time" class="form-label fw-semibold">Check-in Time <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            <input type="time" name="check_in_time" id="check_in_time"
                                   class="form-control @error('check_in_time') is-invalid @enderror time-picker"
                                   value="{{ old('check_in_time', $office_info->check_in_time ?? '09:00') }}" required>
                            @error('check_in_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="check_out_time" class="form-label fw-semibold">Check-out Time <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <input type="time" name="check_out_time" id="check_out_time"
                                   class="form-control @error('check_out_time') is-invalid @enderror time-picker"
                                   value="{{ old('check_out_time', $office_info->check_out_time ?? '17:00') }}" required>
                            @error('check_out_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-header d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-light text-primary me-3">
                                <i class="fas fa-address-book"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Contact Information</h5>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_email" class="form-label fw-semibold">Company Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="company_email" id="company_email"
                                  class="form-control @error('company_email') is-invalid @enderror"
                                  value="{{ old('company_email', $office_info->company_email ?? '') }}"
                                  placeholder="company@example.com" required>
                            @error('company_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_phone" class="form-label fw-semibold">Company Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" name="company_phone" id="company_phone"
                                  class="form-control @error('company_phone') is-invalid @enderror"
                                  value="{{ old('company_phone', $office_info->company_phone ?? '') }}"
                                  placeholder="+1 (123) 456-7890" required>
                            @error('company_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_website" class="form-label fw-semibold">Company Website</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-globe"></i>
                            </span>
                            <input type="url" name="company_website" id="company_website"
                                  class="form-control @error('company_website') is-invalid @enderror"
                                  placeholder="https://example.com"
                                  value="{{ old('company_website', $office_info->company_website ?? '') }}">
                            @error('company_website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-header d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-light text-primary me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Location</h5>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_location" class="form-label fw-semibold">Company Location <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary">
                                <i class="fas fa-city"></i>
                            </span>
                            <input type="text" name="company_location" id="company_location"
                                   class="form-control @error('company_location') is-invalid @enderror"
                                   value="{{ old('company_location', $office_info->company_location ?? '') }}"
                                   placeholder="e.g. New York, USA" required>
                            @error('company_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company_address" class="form-label fw-semibold">Complete Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary-light text-primary align-items-start pt-2">
                                <i class="fas fa-map-pin"></i>
                            </span>
                            <textarea name="company_address" id="company_address"
                                     class="form-control @error('company_address') is-invalid @enderror"
                                     rows="2" placeholder="Street address, floor, suite, etc."
                                     required>{{ old('company_address', $office_info->company_address ?? '') }}</textarea>
                            @error('company_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                <!-- #region
                -->
                <div class="col-md-6 mb-3">
                    <label for="total_leave_days_for_employee_in_year" class="form-label fw-semibold">I Love You, Stranger <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary-light text-primary">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="text" name="total_leave_days_for_employee_in_year" id="total_leave_days_for_employee_in_year"
                              class="form-control @error('total_leave_days_for_employee_in_year') is-invalid @enderror"
                              value="{{ old('total_leave_days_for_employee_in_year', $office_info->total_leave_days_for_employee_in_year ?? '') }}"
                              placeholder="" required>
                        @error('total_leave_days_for_employee_in_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between border-top pt-4">
                    <a href="{{ route('office_info_setup.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>
                        {{ isset($office_info) ? 'Update Settings' : 'Save Settings' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        border-radius: 0 !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }

    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-light {
        background-color: rgba(58, 123, 213, 0.1);
    }

    .section-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .file-upload-wrapper {
        position: relative;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(58, 123, 213, 0.25);
        border-color: #3a7bd5;
    }

    .input-group-text {
        transition: all 0.3s ease;
    }

    .input-group:focus-within .input-group-text {
        background-color: #3a7bd5;
        color: white;
    }

    .time-picker {
        position: relative;
    }

    .time-picker::after {
        content: "\f017";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Enhanced form validation with custom styling
    (function() {
        'use strict';

        // Add custom validation styling
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch all forms we want to apply validation to
            var forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        // Add custom error styling
                        var invalidFields = form.querySelectorAll(':invalid');
                        invalidFields.forEach(function(field) {
                            field.closest('.mb-3').classList.add('was-validated');

                            // Scroll to first invalid field
                            if (invalidFields[0] === field) {
                                field.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        });
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            // Add real-time validation on blur
            document.querySelectorAll('.form-control').forEach(function(input) {
                input.addEventListener('blur', function() {
                    if (input.checkValidity()) {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    } else {
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                    }
                });
            });
        });
    })();
</script>
@endpush
@endsection
