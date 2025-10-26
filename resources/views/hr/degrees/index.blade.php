@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Manage Degrees</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('hr.degrees.create') }}" class="btn btn-primary">Add New Degree</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($degrees as $degree)
                            <tr>
                                <td>{{ $degree->id }}</td>
                                <td>{{ $degree->name }}</td>
                                <td>
                                    <span class="badge {{ $degree->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $degree->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $degree->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('hr.degrees.edit', $degree) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('hr.degrees.destroy', $degree) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No degrees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
