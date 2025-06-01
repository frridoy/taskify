@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h3 class="mb-4">Salary Details for {{ $salary->user->name }}</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Issued Date:</strong> {{ now()->format('d F, Y') }}</p>
            <p><strong>Issued Time:</strong> {{ now()->format('h:i A') }}</p>
            <p><strong>Print By:</strong> {{auth()->user()->name ?? 'N/A'}}</p>
            <p><strong>Basic Salary:</strong> {{ number_format($salary->basic_salary, 2) }}</p>
        </div>
    </div>

    <h4 class="mt-5">All Salary Records for {{ $salary->user->name }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Month</th>
                <th>Year</th>
                <th>Basic</th>
                <th>Bonus</th>
                <th>Total</th>
                <th>Distributed By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allSalaries as $salary)
                <tr @if($salary->id == $salary->id) style="background-color: #e9f7ef;" @endif>
                    <td>{{ config('static_array.months')[$salary->month] ?? 'Unknown' }}</td>
                    <td>{{ $salary->year }}</td>
                    <td>{{ number_format($salary->basic_salary, 2) }}</td>
                    <td>{{ number_format($salary->bonus, 2) }}</td>
                    <td>{{ number_format($salary->total_salary, 2) }}</td>
                    <td>{{ $salary->distributeBy->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
