@extends('setup.master')
@section('content')
<div class="container">
    <h1 class="mb-4">Employee Policies</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Points for Completed Tasks</th>
                    <th>Amount per Point</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee_policies as $employeePolicy)
                    <tr>
                        <td>{{ $employeePolicy->id }}</td>
                        <td>{{ $employeePolicy->points_for_completed_tasks }}</td>
                        <td>{{ $employeePolicy->amount_for_point }}</td>
                        <td>
                            <a href="{{ route('employee_policy.edit', $employeePolicy->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    /* Employee Policies Page Custom CSS */

/* Page Container */
.container {
  max-width: 1140px;
  padding: 2rem 1.5rem;
}

/* Page Title */
h1.mb-4 {
  color: #2c3e50;
  font-weight: 600;
  margin-bottom: 1.5rem !important;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #3498db;
}

/* Table Styling */
.table-responsive {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 2rem;
}

.table {
  margin-bottom: 0;
  border-collapse: collapse;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(52, 152, 219, 0.05);
}

.table-bordered {
  border: none;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #e9ecef;
}

/* Table Header */
.thead-dark th {
  background-color: #3498db;
  color: white;
  border-color: #2980b9;
  padding: 1rem 0.75rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  font-size: 0.9rem;
}

/* Table Body */
.table tbody td {
  padding: 0.75rem;
  vertical-align: middle;
  font-size: 0.95rem;
  color: #444;
}

/* Action Button */
.btn-primary {
  background-color: #3498db;
  border-color: #3498db;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  background-color: #2980b9;
  border-color: #2980b9;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.875rem;
  border-radius: 4px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .table thead th,
  .table tbody td {
    padding: 0.5rem;
    font-size: 0.85rem;
  }
}
</style>
@endsection
