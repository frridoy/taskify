@extends('setup.master')
@section('content')
    <div class="container-fluid py-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Salary Management</h6>
                @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                    <a href="" class="btn btn-primary mt-2 mt-md-0">
                        <i class="fas fa-share-alt"></i> Distribute
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="usersTable">
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
                                <th>
                                    <input type="checkbox" id="checkAll"> Distribute
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBasicSalary = 0;
                                $totalBonus = 0;
                                $totalOverallSalary = 0;
                            @endphp
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
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
                                        <td class="text-center">{{ $user->basic_salary ?? '' }}</td>
                                        <td class="text-center"> {{ $bonus[$user->id] ?? 0 }}</td>
                                        <td class="text-center">
                                            {{ ($user->basic_salary ?? 0) + ($bonus[$user->id] ?? 0) }}
                                        </td>
                                        <td class="text-center">
                                            @if ($user->role == 1)
                                                <i class="fas fa-user-shield text-danger" title="Admin"></i> Admin
                                            @elseif($user->role == 2)
                                                <i class="fas fa-user-tie text-primary" title="Manager"></i> Manager
                                            @elseif($user->role == 3)
                                                <i class="fas fa-user text-success" title="Employee"></i> Employee
                                            @else
                                                <i class="fas fa-question-circle text-muted" title="Unknown Role"></i>
                                                Unknown
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="salary_checkbox[]" value="{{ $user->id }}"
                                                class="salary-checkbox">
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center text-danger">No data found.</td>
                                </tr>
                            @endif

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
                    @if (isset($users) && $users->hasPages())
                        {{ $users->appends(request()->all())->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>

    <style>
        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
            padding: 0.5rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.25rem 0.4rem;
            font-size: 0.75rem;
        }

        .form-select,
        .form-control {
            border-radius: 0.25rem;
            font-size: 0.875rem;
            min-height: calc(1.5em + 0.5rem + 2px);
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-break {
            word-break: break-word !important;
            word-wrap: break-word !important;
        }

        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        @media (max-width: 767.98px) {

            .table th,
            .table td {
                font-size: 0.75rem;
                padding: 0.3rem;
            }
        }

        .gap-1 {
            gap: 0.25rem !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }
    </style>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkAll = document.getElementById('checkAll');
                const checkboxes = document.querySelectorAll('.salary-checkbox');

                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(function(cb) {
                        cb.checked = checkAll.checked;
                    });
                });
            });
        </script>
    @endpush

@endsection
