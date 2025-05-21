@extends('setup.master')
@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>{{ isset($user) ? 'Update User' : 'Create User' }}</title>
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
                        <h2>{{ isset($user) ? 'Update User' : 'Create User' }}</h2>
                        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name:</label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name"
                                            value="{{ old('name', isset($user) ? $user->name : '') }}"
                                            placeholder="example">
                                        @error('name')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email:</label> <span class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('email') is-invalid

                                        @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', isset($user) ? $user->email : '') }}"
                                            placeholder="example@app.com">
                                        @error('email')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role:</label> <span class="text-danger">*</span>
                                        <select class="custom-select @error('role') is-invalid @enderror" id="role"
                                            name="role">
                                            <option value="">Select User Role</option>
                                            <option value="2"
                                                {{ old('role', isset($user) ? $user->role : '') == 2 ? 'selected' : '' }}>HR
                                            </option>
                                            <option value="3"
                                                {{ old('role', isset($user) ? $user->role : '') == 3 ? 'selected' : '' }}>
                                                Employee</option>
                                        </select>
                                        @error('role')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_no">Phone Number:</label> <span class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('phone_no') is-invalid
                                        @enderror"
                                            id="phone_no" name="phone_no"
                                            value="{{ old('phone_no', isset($user) ? $user->phone_no : '') }}"
                                            placeholder="01614898789">
                                        @error('phone_no')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="designation">Designation:</label> <span class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('designation') is-invalid
                                        @enderror"
                                            id="designation" name="designation"
                                            value="{{ old('designation', isset($user) ? $user->designation : '') }}"
                                            placeholder="Software Engineer">
                                        @error('designation')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employee_signature">Signature:</label> <span
                                            class="text-danger">*</span>
                                        <div class="file-input">
                                            <input type="file" class="form-control" id="employee_signature"
                                                name="employee_signature">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status:</label> <span class="text-danger">*</span>
                                        <select class="custom-select" id="status" name="status">
                                            <option value="1"
                                                {{ isset($user) && $user->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0"
                                                {{ isset($user) && $user->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profile_photo">Profile Photo:</label> <span class="text-danger">*</span>
                                        <div class="file-input">
                                            <input type="file" class="form-control" id="profile_photo"
                                                name="profile_photo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="basic_salary">Basic Salary:</label> <span
                                            class="text-danger">*</span>
                                        <div class="file-input">
                                            <input type="text"
                                                class="form-control @error('basic_salary') is-invalid
                                        @enderror"
                                                id="basic_salary" name="basic_salary"
                                                value="{{ old('basic_salary', isset($user) ? $user->basic_salary : '') }}"
                                                placeholder="15000">
                                            @error('basic_salary')
                                                <p class="invalid-feedback"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password:</label> <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password"
                                                {{ isset($user) ? '' : 'required' }}>
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword()">
                                                    <i id="togglePasswordIcon" class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password:</label> <span
                                            class="text-danger">*</span>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                    onclick="togglePassword('password_confirmation', 'toggleConfirmPasswordIcon')">
                                                    <i id="toggleConfirmPasswordIcon" class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-center gap-3 mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg px-4"
                                    style="border-radius: 8px;">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 8px;">
                                    {{ isset($user) ? 'Update' : 'Submit' }}
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("togglePasswordIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
