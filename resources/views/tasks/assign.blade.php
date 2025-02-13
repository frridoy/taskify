@extends('setup.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <!-- Card Header with Smaller Blue Background -->
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="text-center mb-0" style="font-size: 1.5rem;">Assign Task</h3>
                </div>
                <div class="card-body p-5">
                    <!-- Display success message -->

                    <!-- Form to assign task -->
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <!-- Task Name -->
                        <div class="form-group mb-2">
                            <label for="task_name" class="form-label fw-bold">Task Name</label>
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
                            <label for="dateLimit" class="form-label fw-bold">Date Limit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </span>
                                <input type="date" name="dateLimit" id="dateLimit" class="form-control border-start-0" required>
                            </div>
                        </div>

                        <!-- Submit Button (Smaller Size) -->
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
    .alert {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
