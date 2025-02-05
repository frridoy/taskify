@extends('setup.layout')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>{{ isset($user) ? 'Update User' : 'Create User' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>{{ isset($user) ? 'Update User' : 'Create User' }}</h2>
    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($user) ? $user->name : '' }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ isset($user) ? $user->email : '' }}" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role">
                <option value="">Select User Role</option>
                <option value="2" {{ isset($user) && $user->role == 2 ? 'selected' : '' }}>HR</option>
                <option value="3" {{ isset($user) && $user->role == 3 ? 'selected' : '' }}>Employee</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone_no">Phone Number:</label>
            <input type="text" class="form-control" id="phone_no" name="phone_no" value="{{ isset($user) ? $user->phone_no : '' }}">
        </div>
        <div class="form-group">
            <label for="profile_photo">Profile Photo:</label>
            <input type="file" class="form-control" id="profile_photo" name="profile_photo" value="{{ isset($user) ? $user->profile_photo : '' }}">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="1" {{ isset($user) && $user->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ isset($user) && $user->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Submit' }}</button>
    </form>
</div>
</body>
</html>
@endsection
