@extends('setup.master')
@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>Notice Management</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f7fc;
            }

            .container {
                margin-top: 40px;
                margin-bottom: 40px;
            }

            .form-container {
                background: white;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
                position: relative;
                overflow: hidden;
            }

            .form-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: linear-gradient(90deg, #6a11cb, #2575fc);
            }

            .form-header {
                margin-bottom: 35px;
                text-align: center;
                position: relative;
            }

            .form-header::after {
                content: '';
                display: block;
                width: 60px;
                height: 3px;
                background: linear-gradient(90deg, #6a11cb, #2575fc);
                margin: 15px auto 0;
                border-radius: 3px;
            }

            h2 {
                color: #2c3e50;
                font-weight: 600;
                font-size: 26px;
                margin-bottom: 8px;
                letter-spacing: 0.5px;
            }

            .form-subtitle {
                color: #7f8c8d;
                font-size: 15px;
            }

            .form-control,
            .custom-select {
                border-radius: 10px;
                border: 1px solid #e0e6ed;
                padding: 12px 16px;
                transition: all 0.3s ease;
                height: 50px;
                font-size: 14px;
                background-color: #f8fafc;
                color: #2c3e50;
                box-shadow: none !important;
            }

            .form-control:focus,
            .custom-select:focus,
            .select2-container--focus .select2-selection {
                border-color: #6a11cb;
                background-color: #fff;
            }

            textarea.form-control {
                height: auto;
                min-height: 150px;
                resize: vertical;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-group label {
                font-weight: 500;
                color: #34495e;
                margin-bottom: 8px;
                font-size: 14px;
                display: block;
            }

            .required-field {
                color: #e74c3c;
                font-weight: bold;
                margin-left: 3px;
            }

            .section-title {
                color: #2c3e50;
                font-weight: 600;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 1px solid #eaeaea;
                font-size: 18px;
            }

            /* Custom checkbox styles */
            .checkbox-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            }

            .custom-checkbox {
                display: inline-block;
                margin-right: 10px;
                margin-bottom: 10px;
            }

            .custom-checkbox input[type="checkbox"] {
                display: none;
            }

            .custom-checkbox label {
                display: inline-block;
                background-color: #f8fafc;
                border: 1px solid #e0e6ed;
                padding: 8px 16px;
                border-radius: 50px;
                cursor: pointer;
                font-size: 13px;
                transition: all 0.3s ease;
                margin-bottom: 0;
                color: #7f8c8d;
            }

            .custom-checkbox input[type="checkbox"]:checked + label {
                background-color: #6a11cb;
                color: white;
                border-color: #6a11cb;
                box-shadow: 0 3px 10px rgba(106, 17, 203, 0.2);
            }

            /* Date picker styling */
            .date-input-group {
                position: relative;
            }

            .date-input-group i {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: #95a5a6;
                z-index: 10;
                pointer-events: none;
            }

            /* Status toggle switch */
            .toggle-container {
                display: flex;
                align-items: center;
                background-color: #f8fafc;
                padding: 15px 20px;
                border-radius: 10px;
                border: 1px solid #e0e6ed;
            }

            .toggle-label {
                margin-right: 20px;
                font-weight: 500;
                color: #34495e;
                flex-grow: 1;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 30px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #cbd5e0;
                transition: .4s;
                border-radius: 30px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 22px;
                width: 22px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }

            input:checked + .slider {
                background-color: #6a11cb;
            }

            input:checked + .slider:before {
                transform: translateX(30px);
            }

            .status-label {
                margin-left: 15px;
                font-weight: 500;
                font-size: 14px;
                width: 60px;
            }

            .status-active {
                color: #2ecc71;
            }

            .status-inactive {
                color: #e74c3c;
            }

            /* Form footer */
            .form-footer {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 40px;
                padding-top: 30px;
                border-top: 1px solid #eaeaea;
            }

            .btn {
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 30px;
                font-size: 15px;
                font-weight: 500;
                border-radius: 10px;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }

            .btn-primary {
                background: linear-gradient(45deg, #6a11cb, #2575fc);
                border: none;
                box-shadow: 0 5px 15px rgba(37, 117, 252, 0.2);
            }

            .btn-primary:hover {
                background: linear-gradient(45deg, #5900b3, #1c68ea);
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(37, 117, 252, 0.3);
            }

            .btn-outline-secondary {
                border: 1px solid #cbd5e0;
                color: #7f8c8d;
                background: white;
            }

            .btn-outline-secondary:hover {
                background-color: #f8fafc;
                color: #34495e;
                border-color: #95a5a6;
            }

            .invalid-feedback {
                font-size: 12px;
                margin-top: 5px;
                color: #e74c3c;
            }

            .icon-in-btn {
                margin-right: 10px;
                font-size: 16px;
            }

            /* Enhanced Select2 styling */
            .select2-container {
                width: 100% !important;
            }

            .select2-container .select2-selection--single,
            .select2-container .select2-selection--multiple {
                height: 50px;
                border-radius: 10px;
                border: 1px solid #e0e6ed;
                background-color: #f8fafc;
            }

            .select2-container .select2-selection--multiple {
                min-height: 50px;
                padding: 8px 12px;
            }

            .select2-container .select2-selection--single .select2-selection__rendered {
                line-height: 48px;
                padding-left: 16px;
                color: #2c3e50;
            }

            .select2-container .select2-selection--single .select2-selection__arrow {
                height: 48px;
            }

            .select2-container .select2-selection--multiple .select2-selection__rendered {
                padding: 0;
            }

            .select2-container .select2-selection--multiple .select2-selection__choice {
                background-color: #6a11cb;
                color: white;
                border: none;
                border-radius: 50px;
                padding: 5px 12px;
                margin-top: 3px;
                margin-right: 5px;
                font-size: 12px;
            }

            .select2-container .select2-selection--multiple .select2-selection__choice__remove {
                color: white;
                margin-right: 8px;
                font-weight: bold;
            }

            .select2-dropdown {
                border: 1px solid #e0e6ed;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }

            .select2-results__option {
                padding: 10px 16px;
                font-size: 14px;
                transition: all 0.2s;
            }

            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #6a11cb;
            }

            /* Card-like sections */
            .form-section {
                background-color: white;
                border-radius: 12px;
                padding: 25px;
                margin-bottom: 25px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
                border: 1px solid #f0f0f0;
            }

            /* Animation effects */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .form-container {
                animation: fadeIn 0.5s ease-out;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-container">
                        <div class="form-header">
                            <h2>Notice Management</h2>
                            <p class="form-subtitle">Create and publish a new notice in the system</p>
                        </div>

                        <form action="{{ route('notice.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-section">
                                <h3 class="section-title">Basic Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title <span class="required-field">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" value="{{ old('title') }}" placeholder="Enter notice title">
                                            @error('title')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="notice_type">Notice Type <span class="required-field">*</span></label>
                                            <select name="notice_type" id="notice_type"
                                                class="form-control @error('notice_type') is-invalid @enderror">
                                                <option value="">-- Select Notice Type --</option>
                                                @foreach ($notice_types as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('notice_type') == $key ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('notice_type')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="meeting_date_time">Meeting Date & Time <span class="required-field">*</span></label>
                                            <input type="datetime-local"
                                                class="form-control @error('meeting_date_time') is-invalid @enderror"
                                                id="meeting_date_time" name="meeting_date_time"
                                                value="{{ old('meeting_date_time') }}"
                                                placeholder="Enter meeting date and time">
                                            @error('meeting_date_time')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Notice For <span class="required-field">*</span></label>
                                            <div class="checkbox-container">
                                                @foreach ($user_types as $key => $value)
                                                    <div class="custom-checkbox">
                                                        <input type="checkbox" id="notice_for_{{ $key }}"
                                                            name="notice_for[]" value="{{ $key }}"
                                                            {{ (is_array(old('notice_for')) && in_array($key, old('notice_for'))) ? 'checked' : '' }}>
                                                        <label for="notice_for_{{ $key }}">{{ $value }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('notice_for')
                                                <p class="invalid-feedback d-block">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Schedule & Content</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="publish_date">Publish Date <span class="required-field">*</span></label>
                                            <div class="date-input-group">
                                                <input type="datetime-local"
                                                    class="form-control @error('publish_date') is-invalid @enderror"
                                                    id="publish_date" name="publish_date" value="{{ old('publish_date') }}">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            @error('publish_date')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expire_date">Expiry Date <span class="required-field">*</span></label>
                                            <div class="date-input-group">
                                                <input type="datetime-local"
                                                    class="form-control @error('expire_date') is-invalid @enderror"
                                                    id="expire_date" name="expire_date" value="{{ old('expire_date') }}">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            @error('expire_date')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Description field -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description <span class="required-field">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="description" name="description" rows="6"
                                                placeholder="Enter detailed notice description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Status</h3>
                                <!-- Active Status field -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="toggle-container">
                                            <div class="toggle-label">Notice Status</div>
                                            <label class="switch">
                                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <span class="status-label" id="status-text">Active</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-footer">
                                <a href="{{ route('notice.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left icon-in-btn"></i> Back to Notices
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane icon-in-btn"></i> Publish Notice
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle switch functionality
                const statusCheckbox = document.getElementById('is_active');
                const statusText = document.getElementById('status-text');

                function updateStatus() {
                    if (statusCheckbox.checked) {
                        statusText.textContent = 'Active';
                        statusText.classList.add('status-active');
                        statusText.classList.remove('status-inactive');
                    } else {
                        statusText.textContent = 'Inactive';
                        statusText.classList.add('status-inactive');
                        statusText.classList.remove('status-active');
                    }
                }

                statusCheckbox.addEventListener('change', updateStatus);
                updateStatus(); // Set initial state
            });
        </script>
    </body>
    </html>
@endsection
