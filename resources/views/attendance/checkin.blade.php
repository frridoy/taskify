@extends('setup.master')
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
    <h2 class="attendance-title">Attendance for Today</h2>

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

    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="location" id="location">

        <button type="submit" class="circle-checkin {{ $checkedInToday ? 'checked-in' : '' }}">
            {{ $checkedInToday ? 'Checked In' : 'Check In' }}
        </button>
    </form>
</div>

<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const location = position.coords.latitude + ',' + position.coords.longitude;
            document.getElementById('location').value = location;
        }, function() {
            document.getElementById('location').value = 0;
        });
    } else {
        document.getElementById('location').value = 'Geolocation not supported';
    }
</script>
@endsection
