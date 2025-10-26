@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Create New Job Post</h6>
            <a href="{{ route('hr.job_posts.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('hr.job_posts.store') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="font-weight-bold mb-0">Job Details</h6>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Salary Range <span class="text-danger">*</span></label>
                            <input type="text" name="salary_range" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vacancies <span class="text-danger">*</span></label>
                            <input type="number" name="vacancies" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Employment Type <span class="text-danger">*</span></label>
                            <select name="employment_type" class="form-control form-control-sm" required>
                                <option value="">Select Type</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Application Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="application_start_date" class="form-control form-control-sm"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Application Deadline <span class="text-danger">*</span></label>
                            <input type="date" name="deadline" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sex Preference</label>
                            <select name="sex" class="form-control form-control-sm">
                                <option value="">Any</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Age Min</label>
                            <input type="number" name="age_min" class="form-control form-control-sm" placeholder="18">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Age Max</label>
                            <input type="number" name="age_limit" class="form-control form-control-sm" placeholder="35">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Job Image</label>
                            <input type="file" name="image" id="jobImage" accept="image/*"
                                class="form-control form-control-sm">
                            <div class="mt-2 text-center">
                                <img id="imagePreview" src="" alt="Image Preview"
                                    class="img-fluid rounded shadow-sm d-none"
                                    style="max-width: 200px; border:1px solid #ddd;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="font-weight-bold mb-0">Required Education</h6>
                        <button type="button" class="btn btn-success btn-sm addRow">
                            <i class="fas fa-plus"></i> Add Education
                        </button>
                    </div>
                    <div class="card-body" id="educationRepeater">
                        <div class="education-row row g-2 mb-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Degree</label>
                                <select name="educations[0][degree_id]" class="form-control form-control-sm select2"
                                    required>
                                    <option value="">Select Degree</option>
                                    @foreach($degrees as $degree)
                                    <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Institute</label>
                                <input type="text" name="educations[0][institute_name]"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Result</label>
                                <input type="text" name="educations[0][result]" class="form-control form-control-sm"
                                    required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Out of</label>
                                <select name="educations[0][out_of_result]" class="form-control form-control-sm"
                                    required>
                                    <option value="4.00">4.00</option>
                                    <option value="5.00">5.00</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex">
                                <button type="button" class="btn btn-danger btn-sm removeRow w-100 d-none">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="font-weight-bold mb-0">Job Description & Requirements</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Job Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" class="form-control form-control-sm"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Requirements <span class="text-danger">*</span></label>
                            <textarea name="requirements" rows="4" class="form-control form-control-sm"
                                required></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <div class="form-check d-inline-block">
                        <input class="form-check-input" type="checkbox" id="confirmCheckbox">
                        <label class="form-check-label" for="confirmCheckbox">
                            I confirm all information is correct
                        </label>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary d-none" id="createButton">
                        <i class="fas fa-save"></i> Create Job Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        font-size: 0.875rem;
    }

    .education-row {
        border: 1px solid #eee;
        background: #f9f9f9;
        border-radius: 5px;
        padding: 10px;
    }
</style>
@endpush

@push('js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
    let repeaterIndex = 1;
    const maxRows = 10;
    $('.select2').select2({ theme: 'bootstrap4', width: '100%' });

    // Add Education Row
    $(document).on('click', '.addRow', function() {
        const totalRows = $('#educationRepeater .education-row').length;
        if (totalRows >= maxRows) {
            alert('You can add a maximum of 10 education records.');
            return;
        }

        const newRow = `
        <div class="education-row row g-2 mb-2 align-items-end">
            <div class="col-md-3">
                <select name="educations[${repeaterIndex}][degree_id]" class="form-control form-control-sm select2" required>
                    <option value="">Select Degree</option>
                    @foreach($degrees as $degree)
                    <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="educations[${repeaterIndex}][institute_name]" class="form-control form-control-sm" placeholder="Institute" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="educations[${repeaterIndex}][result]" class="form-control form-control-sm" placeholder="e.g. 3.80" required>
            </div>
            <div class="col-md-2">
                <select name="educations[${repeaterIndex}][out_of_result]" class="form-control form-control-sm" required>
                    <option value="4.00">4.00</option>
                    <option value="5.00">5.00</option>
                </select>
            </div>
            <div class="col-md-2 d-flex">
                <button type="button" class="btn btn-danger btn-sm removeRow w-100">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>`;
        $('#educationRepeater').append(newRow);
        $('.select2').select2({ theme: 'bootstrap4', width: '100%' });
        repeaterIndex++;
    });

    // Remove Education Row
    $(document).on('click', '.removeRow', function() {
        $(this).closest('.education-row').remove();
    });

    $('#jobImage').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#confirmCheckbox').on('change', function() {
        $('#createButton').toggleClass('d-none', !this.checked);
    });
});
</script>
@endpush
@endsection
