@extends('setup.master')
@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>{{ isset($office_info) ? 'Update organization Information' : 'Create organization Information' }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 50px;
            }

            .form-container {
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                margin-top: -25px;
            }

            h2 {
                color: #343a40;
                font-weight: 600;
                margin-bottom: 30px;
                text-align: center;
            }

            .form-control,
            .custom-select {
                border-radius: 8px;
                border: 1px solid #ced4da;
                padding: 12px;
                transition: all 0.3s ease;
                height: 45px;
            }

            .form-control:focus,
            .custom-select:focus {
                border-color: #6a11cb;
                box-shadow: 0 0 8px rgba(106, 17, 203, 0.2);
            }

            .form-group label {
                font-weight: 500;
                color: #495057;
            }

            .btn-primary {
                background-color: #6a11cb;
                border: none;
                border-radius: 8px;
                padding: 12px 30px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #2575fc;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(106, 17, 203, 0.3);
            }

            .btn-primary:active {
                transform: translateY(0);
            }

            .file-input {
                display: flex;
                align-items: center;
            }

            .file-input input[type="file"] {
                flex-grow: 1;
                height: 45px;
            }

            .row {
                margin-bottom: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-container">
                        <h2>{{ isset($office_info) ? 'Update organization Information' : 'Create organization Information' }}</h2>
                        <form
                            action="{{ isset($office_info) ? route('office_info_setup.update', $office_info->id) : route('office_info_setup.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($office_info))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Company Name:</label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="company_name" name="company_name"
                                            value="{{ old('company_name', isset($office_info) ? $office_info->company_name : '') }}"
                                            placeholder="Needs Ltd.">
                                        @error('company_name')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_logo">Company Logo:</label> <span class="text-danger">*</span>
                                        <input type="file"
                                            class="form-control @error('company_logo') is-invalid

                                        @enderror"
                                            id="company_logo" name="company_logo">
                                        @error('company_logo')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="check_in_time">Check in Time:</label> <span class="text-danger">*</span>
                                        <input type="time"
                                            class="form-control @error('check_in_time') is-invalid
                                        @enderror"
                                            id="check_in_time" name="check_in_time"
                                            value="{{ old('check_in_time', isset($office_info) ? $office_info->check_in_time : '') }}">
                                        @error('check_in_time')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="check_out_time">Check out Time:</label> <span
                                            class="text-danger">*</span>
                                        <input type="time"
                                            class="form-control @error('check_out_time') is-invalid
                                        @enderror"
                                            id="check_out_time" name="check_out_time"
                                            value="{{ old('check_out_time', isset($office_info) ? $office_info->check_out_time : '') }}">
                                        @error('check_out_time')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_email">Company Email:</label> <span class="text-danger">*</span>
                                        <input type="email"
                                            class="form-control @error('company_email') is-invalid
                                        @enderror"
                                            id="company_email" name="company_email"
                                            value="{{ old('company_email', isset($office_info) ? $office_info->company_email : '') }}"
                                            placeholder="example@app.com">
                                        @error('company_email')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_phone">Company Phone:</label> <span class="text-danger">*</span>
                                        <input type="number"
                                            class="form-control @error('company_phone') is-invalid
                                        @enderror"
                                            id="company_phone" name="company_phone"
                                            value="{{ old('company_phone', isset($office_info) ? $office_info->company_phone : '') }}"
                                            placeholder="01614898789">
                                        @error('company_phone')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_leave_days_for_employee_in_year">Total Leave Days in Year:</label>
                                        <span class="text-danger">*</span>
                                        <input type="number"
                                            class="form-control @error('total_leave_days_for_employee_in_year') is-invalid
                                        @enderror"
                                            id="total_leave_days_for_employee_in_year"
                                            name="total_leave_days_for_employee_in_year"
                                            value="{{ old('total_leave_days_for_employee_in_year', isset($office_info) ? $office_info->total_leave_days_for_employee_in_year : '') }}"
                                            placeholder="Total Leave Days in Year">
                                        @error('total_leave_days_for_employee_in_year')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_location">Company Location:</label> <span
                                            class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('company_location') is-invalid
                                        @enderror"
                                            id="company_location" name="company_location"
                                            value="{{ old('company_location', isset($office_info) ? $office_info->company_location : '') }}"
                                            placeholder="Dhaka">
                                        @error('company_location')
                                            <p class="invalid-feedback"> {{ $message }}
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_description">Company Description:</label>
                                        <span class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('company_description') is-invalid
                                        @enderror"
                                            id="company_description" name="company_description"
                                            value="{{ old('company_description', isset($office_info) ? $office_info->company_description : '') }}"
                                            placeholder="Write about your company">
                                        @error('company_description')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_facebook">Company Facebook:</label> <span
                                            class="text-danger">*</span>
                                        <input type="url"
                                            class="form-control @error('company_facebook') is-invalid
                                        @enderror"
                                            id="company_facebook" name="company_facebook"
                                            value="{{ old('company_facebook', isset($office_info) ? $office_info->company_facebook : '') }}"
                                            placeholder="www.facebook.com">
                                        @error('company_facebook')
                                            <p class="invalid-feedback"> {{ $message }}
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_twitter">Company Twitter:</label>
                                        <span class="text-danger">*</span>
                                        <input type="url"
                                            class="form-control @error('company_twitter') is-invalid
                                        @enderror"
                                            id="company_twitter" name="company_twitter"
                                            value="{{ old('company_twitter', isset($office_info) ? $office_info->company_twitter : '') }}"
                                            placeholder="www.twitter.com">
                                        @error('company_twitter')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_linkedin">Company Linkedin:</label> <span
                                            class="text-danger">*</span>
                                        <input type="url"
                                            class="form-control @error('company_linkedin') is-invalid
                                        @enderror"
                                            id="company_linkedin" name="company_linkedin"
                                            value="{{ old('company_linkedin', isset($office_info) ? $office_info->company_linkedin : '') }}"
                                            placeholder="www.linkedin.com">
                                        @error('company_linkedin')
                                            <p class="invalid-feedback"> {{ $message }}
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-center gap-3 mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg px-4"
                                    style="border-radius: 8px;">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 8px;">
                                    {{ isset($office_info) ? 'Update' : 'Submit' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
