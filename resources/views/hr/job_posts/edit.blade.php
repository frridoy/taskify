@extends('admin.layouts.app')

@section('title', 'Edit Job Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Job Post</h3>
                    <div class="card-tools">
                        <a href="{{ route('hr.job_posts.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
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

                    <form action="{{ route('hr.job_posts.update', $jobPost) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $jobPost->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Job Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $jobPost->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="requirements">Requirements <span class="text-danger">*</span></label>
                            <textarea name="requirements" id="requirements" class="form-control" rows="5" required>{{ old('requirements', $jobPost->requirements) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="salary_range">Salary Range <span class="text-danger">*</span></label>
                            <input type="text" name="salary_range" id="salary_range" class="form-control" value="{{ old('salary_range', $jobPost->salary_range) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="location">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $jobPost->location) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deadline">Application Deadline <span class="text-danger">*</span></label>
                            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $jobPost->deadline->format('Y-m-d')) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Required Degrees <span class="text-danger">*</span></label>
                            <div class="select2-purple">
                                <select name="degree_ids[]" class="select2" multiple="multiple" data-placeholder="Select degrees" required>
                                    @foreach($degrees as $degree)
                                        <option value="{{ $degree->id }}"
                                            {{ in_array($degree->id, old('degree_ids', $jobPost->degrees->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $degree->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $jobPost->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Job Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endpush
