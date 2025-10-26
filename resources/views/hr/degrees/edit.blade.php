@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Edit Degree</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hr.degrees.update', $degree) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Degree Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name', $degree->name) }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="is_active"
                               name="is_active"
                               {{ $degree->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Degree</button>
                    <a href="{{ route('hr.degrees.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
