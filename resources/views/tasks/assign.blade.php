@extends('setup.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="text-center mb-0" style="font-size: 1.5rem;">Assign Task</h3>
                </div>
                <div class="card-body p-5">
                    <!-- Form to assign task -->
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <!-- Task Name -->
                        <div class="form-group mb-2">
                            <label for="task_name" class="form-label fw-bold">Task Name</label> <span class="text-danger">*</span>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-tasks text-primary"></i>
                                </span>
                                <input type="text" name="task_name" id="task_name" class="form-control border-start-0" placeholder="Enter task name" required>
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="form-group mb-2">
                            <label for="task_description" class="form-label fw-bold">Task Description</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-align-left text-primary"></i>
                                </span>
                                <textarea name="task_description" id="task_description" class="form-control border-start-0" rows="4" placeholder="Enter task description" required></textarea>
                            </div>
                        </div>

                        <!-- Date Limit -->
                        <div class="form-group mb-2">
                            <label for="dateLimit" class="form-label fw-bold">Date Limit</label> <span class="text-danger">*</span>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </span>
                                <input type="date" name="dateLimit" id="dateLimit" class="form-control border-start-0" required>
                            </div>
                        </div>

                        <!-- Task Urgency Level (Updated) -->
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Task Urgency</label> <span class="text-danger">*</span>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" id="emergency" name="task_urgency" value="emergency" class="form-check-input" required>
                                    <label for="emergency" class="form-check-label text-danger fw-bold">
                                        <i class="fas fa-exclamation-triangle text-danger me-1"></i> Emergency
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="high_priority" name="task_urgency" value="high_priority" class="form-check-input">
                                    <label for="high_priority" class="form-check-label text-warning fw-bold">
                                        <i class="fas fa-exclamation-circle text-warning me-1"></i> High Priority
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="normal_priority" name="task_urgency" value="normal_priority" class="form-check-input">
                                    <label for="normal_priority" class="form-check-label text-primary fw-bold">
                                        <i class="fas fa-info-circle text-primary me-1"></i> Normal Priority
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="low_priority" name="task_urgency" value="low_priority" class="form-check-input">
                                    <label for="low_priority" class="form-check-label text-secondary fw-bold">
                                        <i class="fas fa-check-circle text-secondary me-1"></i> Low Priority
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-paper-plane me-2"></i> Assign Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for additional styling -->
<style>
    .card {
        margin-top: 2rem;
    }
    .card-header {
        padding: 0.50rem 1.0rem; /* Smaller padding for the header */
    }
    .form-control {
        border-radius: 0.375rem;
    }
    .input-group-text {
        border-radius: 0.375rem 0 0 0.375rem;
    }
    .btn-sm {
        padding: 0.5rem 1rem; /* Smaller button size */
        font-size: 0.9rem; /* Smaller font size for the button */
    }
    .form-check-label {
        cursor: pointer;
    }
</style>
@endsection
