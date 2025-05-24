@extends('setup.master')
@section('content')
<div class="container-fluid py-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Salary Management</h6>
            @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                <button type="submit" class="btn btn-primary mt-2 mt-md-0" form="distributeForm">
                    <i class="fas fa-share-alt"></i> Distribute
                </button>
            @endif
        </div>

        <div class="card-body">
            <form action="{{ route('employee-salaries.store') }}" method="POST" id="distributeForm">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-3 mb-2">
                        <label for="selected_month" class="form-label">Month</label>
                        <select name="selected_month" id="selected_month" class="form-select" required>
                            <option value="">Select Month</option>
                            @foreach ($salaryMonths as $key => $value)
                                <option value="{{ $key }}" {{ $key == $selectedMonth ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="selected_year" class="form-label">Year</label>
                        <select name="selected_year" id="selected_year" class="form-select" required>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 d-flex align-items-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('employee-salaries.index') }}" class="btn btn-secondary">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="font-size: 0.875rem;">
                        <thead class="table-dark">
                            <tr>
                                <th>SI</th>
                                <th>Employee Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Designation</th>
                                <th>Basic Salary</th>
                                <th>Bonus</th>
                                <th>Total Salary</th>
                                <th>Role</th>
                                <th><input type="checkbox" id="checkAll"> Distribute</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBasicSalary = 0;
                                $totalBonus = 0;
                                $totalOverallSalary = 0;
                            @endphp
                            @forelse ($users as $index => $user)
                                @php
                                    $basic = $user->basic_salary ?? 0;
                                    $bonusAmt = $bonus[$user->id] ?? 0;
                                    $total = $basic + $bonusAmt;

                                    $totalBasicSalary += $basic;
                                    $totalBonus += $bonusAmt;
                                    $totalOverallSalary += $total;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_no }}</td>
                                    <td>{{ $user->designation ?? '' }}</td>
                                    <td class="text-center">{{ $basic }}</td>
                                    <td class="text-center">{{ $bonusAmt }}</td>
                                    <td class="text-center">{{ $total }}</td>
                                    <td class="text-center">
                                        @if ($user->role == 1)
                                            <i class="fas fa-user-shield text-danger" title="Admin"></i>
                                        @elseif($user->role == 2)
                                            <i class="fas fa-user-tie text-primary" title="Manager"></i>
                                        @elseif($user->role == 3)
                                            <i class="fas fa-user text-success" title="Employee"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="salaries[{{ $index }}][selected]" value="1" class="salary-checkbox">
                                        <input type="hidden" name="salaries[{{ $index }}][user_id]" value="{{ $user->id }}">
                                        <input type="hidden" name="salaries[{{ $index }}][basic_salary]" value="{{ $basic }}">
                                        <input type="hidden" name="salaries[{{ $index }}][bonus]" value="{{ $bonusAmt }}">
                                        <input type="hidden" name="salaries[{{ $index }}][total_salary]" value="{{ $total }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Total:</th>
                                <th class="text-center">{{ $totalBasicSalary }}</th>
                                <th class="text-center">{{ $totalBonus }}</th>
                                <th class="text-center">{{ $totalOverallSalary }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    @if ($users->hasPages())
                        {{ $users->appends(request()->all())->links() }}
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('checkAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.salary-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });
</script>
@endpush
@endsection
