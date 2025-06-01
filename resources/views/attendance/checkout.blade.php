@extends('admin.layouts.app')
@section('content')
<style>
    .attendance-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 70vh;
        text-align: center;
    }

    .circle-checkin {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #ff0000;
        color: white;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }

    .circle-checkin:hover {
        transform: scale(1.05);
    }

    .attendance-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .alert {
        max-width: 400px;
        margin: 10px auto;
    }

    .checked-in {
        background-color: #007bff;
    }
</style>

<div class="attendance-container">
    <h2 class="attendance-title">Checkout for Today</h2>

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

    <form action="{{ route('check_out_update', $checkout->id) }}" method="POST">
        @csrf
        <button type="submit" class="circle-checkin {{ $checkout ? 'checked-out' : '' }}">
            {{ $checkout ? 'Checked Out' : 'Check Out' }}
        </button>
    </form>
</div>
@endsection
