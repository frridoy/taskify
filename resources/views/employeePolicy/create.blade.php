@extends('admin.layouts.app')
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
                        <h2>{{ isset($employee_policies->id) ? 'Update Employee Policy' : 'Create Employee Policy' }}</h2>
                        <form action="{{ isset($employee_policies->id) ? route('employee_policy.update', $employee_policies->id) : route('employee_policy.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($employee_policies->id))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points_for_completed_tasks">Points for Completed Task:</label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control @error('points_for_completed_tasks') is-invalid @enderror"
                                            id="points_for_completed_tasks" name="points_for_completed_tasks" value="{{old('points_for_completed_tasks', isset($employee_policies->id) ? $employee_policies->points_for_completed_tasks : '') }}"
                                            placeholder="example">
                                            @error('points_for_completed_tasks')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Amount for Point:</label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control @error('amount_for_point') is-invalid

                                        @enderror" id="amount_for_point" name="amount_for_point"
                                            value="{{old('amount_for_point', isset($employee_policies) ? $employee_policies->amount_for_point : '') }}"
                                            placeholder="example@app.com">
                                            @error('amount_for_point')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center gap-3 mt-4">
                                <a href="" class="btn btn-outline-secondary btn-lg px-4" style="border-radius: 8px;">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 8px;">
                                    {{ isset($employee_policies->id) ? 'Update' : 'Submit' }}
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
