@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Edit Team</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('team.update', $team_number) }}" method="POST" id="teamForm">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_name" class="form-label fw-bold">Team Name</label>
                                <input type="text" class="form-control form-control-lg" id="team_name" name="team_name"
                                    value="{{ old('team_name', $teamMembers[0]->team_name) }}" required>
                                @error('team_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-hover align-middle">
                            <thead class="table-black">
                                <tr>
                                    <th width="60%">Employee</th>
                                    <th width="20%" class="text-center">Team Leader</th>
                                    <th width="20%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="teamMembersBody">
                                @foreach ($teamMembers as $member)
                                    <tr class="member-row">
                                        <td>
                                            <select name="user_id[]" class="form-select select-employee" required>
                                                <option value="">Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ $member->user_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                                @if (!$employees->contains('id', $member->user_id))
                                                    <option value="{{ $member->user_id }}" selected>
                                                        {{ $member->employee->name }}</option>
                                                @endif
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input team-leader-radio" type="radio"
                                                    name="team_leader" value="{{ $member->user_id }}"
                                                    {{ $member->is_team_leader ? 'checked' : '' }} required>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-member">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button type="button" class="btn btn-success" id="addMemberBtn">
                            <i class="fas fa-plus-circle"></i> Add Member
                        </button>

                        <div class="action-buttons">
                            <a href="{{ route('team.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Team
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            padding: 0.5rem 1rem;
        }

        .form-control-lg {
            padding: 0.75rem 1.25rem;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .member-row:hover {
            background-color: #f8f9fa;
        }

        .select-employee {
            min-width: 200px;
        }

        .team-leader-radio {
            transform: scale(1.3);
        }

        .btn-remove-member {
            transition: all 0.2s;
        }

        .btn-remove-member:hover {
            transform: translateY(-1px);
        }

        #addMemberBtn {
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }

        .action-buttons .btn {
            min-width: 120px;
        }

        @media (max-width: 768px) {
            .action-buttons {
                width: 100%;
                margin-top: 1rem;
            }

            .action-buttons .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const employees = @json($employees);
            const teamMembersBody = document.getElementById('teamMembersBody');
            const addMemberBtn = document.getElementById('addMemberBtn');

            addMemberBtn.addEventListener('click', function() {
                const tr = document.createElement('tr');
                tr.className = 'member-row';
                let employeeOptions = '<option value="">Select Employee</option>';
                employees.forEach(employee => {
                    employeeOptions += `<option value="${employee.id}">${employee.name}</option>`;
                });

                tr.innerHTML = `
            <td>
                <select name="user_id[]" class="form-select select-employee" required>
                    ${employeeOptions}
                </select>
            </td>
            <td class="text-center">
                <div class="form-check d-flex justify-content-center">
                    <input class="form-check-input team-leader-radio" type="radio"
                           name="team_leader" value="" required>
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-member">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;

                teamMembersBody.appendChild(tr);
                updateRadioButtons();

                tr.querySelector('.btn-remove-member').addEventListener('click', function() {
                    if (teamMembersBody.querySelectorAll('tr').length > 1) {
                        tr.remove();
                        ensureTeamLeaderExists();
                    } else {
                        showToast('error', 'A team must have at least one member');
                    }
                });

                tr.querySelector('.select-employee').addEventListener('change', function() {
                    updateRadioButtons();
                });
            });

            document.querySelectorAll('.btn-remove-member').forEach(button => {
                button.addEventListener('click', function() {
                    if (teamMembersBody.querySelectorAll('tr').length > 1) {
                        this.closest('tr').remove();
                        ensureTeamLeaderExists();
                    } else {
                        showToast('error', 'A team must have at least one member');
                    }
                });
            });

            function updateRadioButtons() {
                const rows = teamMembersBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const select = row.querySelector('.select-employee');
                    const radio = row.querySelector('.team-leader-radio');
                    if (select && radio) {
                        radio.value = select.value;
                        if (radio.checked && !select.value) {
                            radio.checked = false;
                        }
                    }
                });

                ensureTeamLeaderExists();
            }

            function ensureTeamLeaderExists() {
                if (!document.querySelector('.team-leader-radio:checked')) {
                    const firstRadio = document.querySelector('.team-leader-radio');
                    if (firstRadio) {
                        firstRadio.checked = true;
                    }
                }
            }

            function showToast(type, message) {
                alert(message);
            }

            updateRadioButtons();

            document.getElementById('teamForm').addEventListener('submit', function(e) {
                if (!document.querySelector('.team-leader-radio:checked')) {
                    e.preventDefault();
                    showToast('error', 'Please select a team leader');
                    return false;
                }

                const memberIds = [];
                let hasDuplicates = false;

                document.querySelectorAll('.select-employee').forEach(select => {
                    if (select.value) {
                        if (memberIds.includes(select.value)) {
                            hasDuplicates = true;
                            select.classList.add('is-invalid');
                        } else {
                            memberIds.push(select.value);
                            select.classList.remove('is-invalid');
                        }
                    }
                });

                if (hasDuplicates) {
                    e.preventDefault();
                    showToast('error', 'Duplicate team members are not allowed');
                    return false;
                }
            });
        });
    </script>
@endsection
