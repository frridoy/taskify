@extends('setup.layout')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>{{ isset($user) ? 'Update User' : 'Create User' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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
        }
        h2 {
            color: #343a40;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control, .custom-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px;
            transition: all 0.3s ease;
            height: 45px;
        }
        .form-control:focus, .custom-select:focus {
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
                <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ isset($user) ? $user->name : '' }}" placeholder="example" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ isset($user) ? $user->email : '' }}" placeholder="example@app.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="custom-select" id="role" name="role">
                                    <option value="">Select User Role</option>
                                    <option value="2" {{ isset($user) && $user->role == 2 ? 'selected' : '' }}>HR</option>
                                    <option value="3" {{ isset($user) && $user->role == 3 ? 'selected' : '' }}>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_no">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_no" name="phone_no" value="{{ isset($user) ? $user->phone_no : '' }}" placeholder="01614898789"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="custom-select" id="status" name="status">
                                    <option value="1" {{ isset($user) && $user->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ isset($user) && $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_photo">Profile Photo:</label>
                                <div class="file-input">
                                    <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
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
                                <label for="password_confirmation">Confirm Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePassword('password_confirmation', 'toggleConfirmPasswordIcon')">
                                            <i id="toggleConfirmPasswordIcon" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Submit' }}</button>
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
