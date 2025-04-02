{{-- @extends('setup.layout')
@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0 fs-4">Build Your Team</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('team.store') }}" method="POST">
                    @csrf

                    <!-- Team Name Input -->
                    <div class="mb-3">
                        <label for="team_name" class="form-label">Team Name</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th style="width: 60%">Employee</th>
                                        <th style="width: 20%" class="text-center">Team Leader</th>
                                        <th style="width: 20%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="employee-container">
                                    <tr class="employee-row align-middle">
                                        <td>
                                            <select name="employee_id[]" class="form-select">
                                                <option value="">Select Employee</option>

                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-inline-block">
                                                    <input type="radio" name="team_leader" value="{{ $employee->id }}"
                                                        class="form-check-input">

                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-success add-row">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger remove-row"
                                                style="display: none;">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            let rowCount = 1;

            $(document).on('click', '.add-row', function() {
                rowCount++;
                let newRow = $('.employee-row:first').clone();

                // Reset select value
                newRow.find('select').val('');

                // Reset and update radio button
                newRow.find('input[type="radio"]').prop('checked', false)
                    .attr('id', 'leader-' + rowCount)
                    .val(rowCount);
                newRow.find('label').attr('for', 'leader-' + rowCount);

                // Show/hide appropriate buttons
                newRow.find('.add-row').hide();
                newRow.find('.remove-row').show();

                $('#employee-container').append(newRow);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.employee-row').remove();
            });
        });
    </script>
@endsection --}}



@extends('setup.layout')
@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0 fs-4">Build Your Team</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('team.store') }}" method="POST">
                    @csrf

                    <!-- Team Name Input -->
                    <div class="mb-3">
                        <label for="team_name" class="form-label">Team Name</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" value="{{ old('team_name') }}" >
                    </div>

                    <div class="mb-3">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th style="width: 60%">Employee</th>
                                        <th style="width: 20%" class="text-center">Team Leader</th>
                                        <th style="width: 20%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="employee-container">
                                    <tr class="employee-row align-middle">
                                        <td>
                                            <select name="employee_id[]" class="form-select employee-select">
                                                <option value="">Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-inline-block">
                                                <input type="radio" name="team_leader" class="form-check-input team-leader-radio" value="" >
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-success add-row">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger remove-row" style="display: none;">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            let rowCount = 1;

            $(document).on('click', '.add-row', function() {
                rowCount++;
                let newRow = $('.employee-row:first').clone();

                newRow.find('select').val('');
                newRow.find('input[type="radio"]').prop('checked', false).val('');

                newRow.find('.add-row').hide();
                newRow.find('.remove-row').show();
                $('#employee-container').append(newRow);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.employee-row').remove();
            });

            $(document).on('change', '.employee-select', function() {
                let employeeId = $(this).val();
                $(this).closest('tr').find('.team-leader-radio').val(employeeId);
            });
        });
    </script>
@endsection
