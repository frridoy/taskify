@extends('setup.master')
@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title></title>
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
                        <h2 class="mb-4">Leave Request</h2>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="alert alert-info mb-0">
                                    <strong>Total Leave Taken ({{ date('Y') }}):</strong> {{ $leave_spent_days }} day{{ $leave_spent_days > 1 ? 's' : '' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-success mb-0">
                                    <strong>Remaining Leave ({{ date('Y') }}):</strong> {{ $leave_days_left }} day{{ $leave_days_left > 1 ? 's' : '' }}
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('leave_request_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label> <span class="text-danger">*</span>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date" value="{{ old('start_date') }}"
                                            min="{{ \Carbon\Carbon::now()->toDateString() }}" placeholder="">
                                        @error('start_date')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label> <span class="text-danger">*</span>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                            name="end_date" placeholder=""
                                            min="{{ \Carbon\Carbon::now()->toDateString() }}"
                                            value="{{ old('end_date') }}">

                                        @error('end_date')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_request_type">Leave Request Type:</label> <span
                                            class="text-danger">*</span>
                                        <select name="leave_request_type" id="leave_request_type"
                                            class="form-control @error('leave_request_type') is-invalid @enderror">
                                            <option value="">-- Select Leave Type --</option>
                                            @foreach ($leave_request_type as $key => $value)
                                                {{-- <option value="{{ $key }}">{{ $value }}</option> --}}
                                                <option value="{{ $key }}"
                                                    {{ old('leave_request_type') == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>

                                        @error('leave_request_type')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reason_description">Reason Description:</label> <span
                                            class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('reason_description') is-invalid @enderror"
                                            id="reason_description" name="reason_description"
                                            value="{{ old('reason_description') }}" placeholder="Describe your reason">
                                        @error('reason_description')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_request_document">Document:</label>
                                        <div class="file-input">
                                            <input type="file" class="form-control" id="leave_request_document"
                                                name="leave_request_document">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_left">Leave Left {{ date('Y') }}:</label> <span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" id="leave_left" name="leave_left"
                                            value="{{ $leave_days_left }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center gap-3 mt-4">
                                <a href="" class="btn btn-outline-secondary btn-lg px-4" style="border-radius: 8px;">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </a>

                                @if ($pending_request->isEmpty())
                                    <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 8px;">
                                        Request
                                    </button>
                                @else
                                    <div class="alert alert-warning mb-0 px-3 py-2" role="alert"
                                        style="border-radius: 8px;">
                                        You already have a pending leave request.
                                    </div>
                                @endif
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
