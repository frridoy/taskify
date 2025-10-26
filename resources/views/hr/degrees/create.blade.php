@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Create New Degree</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hr.degrees.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Degree Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Create Degree</button>
                    <a href="{{ route('hr.degrees.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
