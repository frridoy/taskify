@extends('setup.master')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="page-title">Employee Reward Policy</h1>
        @if(auth()->user()->role == 1)
        <a href="{{ route('employee_policy.edit', $employee_policies[0]->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Policy
        </a>
        @endif
    </div>

    <div class="policy-card-container">
        <div class="policy-card">
            <div class="policy-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="policy-details">
                <h3>Points for Completed Tasks</h3>
                <p class="policy-value">{{ $employee_policies[0]->points_for_completed_tasks }} points</p>
                <p class="policy-description">Points awarded for each completed task on date limit</p>
            </div>
        </div>

        <div class="policy-card">
            <div class="policy-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="policy-details">
                <h3>Monetary Value per Point</h3>
                <p class="policy-value">{{ number_format($employee_policies[0]->amount_for_point, 2) }}</p>
                <p class="policy-description">Amount earned for each point accumulated</p>
            </div>
        </div>

        <div class="policy-card">
            <div class="policy-icon">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="policy-details">
                <h3>Example Calculation</h3>
                <p class="policy-value">5 tasks = {{ number_format(5 * $employee_policies[0]->points_for_completed_tasks * $employee_policies[0]->amount_for_point, 2) }}</p>
                <p class="policy-description">Based on current policy values for completion task</p>
            </div>
        </div>
    </div>

    <div class="policy-notes mt-5">
        <div class="note-header">
            <h3><i class="fas fa-info-circle"></i> Policy Notes</h3>
        </div>
        <div class="note-content">
            <ul>
                <li>Points are awarded only after task completion on date limit</li>
                <li>Rewards are processed at the end of each pay period</li>
                <li>Policy changes must be approved by HR and management</li>
            </ul>
        </div>
    </div>
</div>

<style>

.container {
  max-width: 1140px;
  padding: 2rem 1.5rem;
}

.page-title {
  color: #2c3e50;
  font-weight: 600;
  margin: 0;
  position: relative;
  padding-bottom: 0.5rem;
}

.page-title::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background-color: #3498db;
}

.policy-card-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.policy-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  border-top: 4px solid #3498db;
}

.policy-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.policy-icon {
  font-size: 2.5rem;
  color: #3498db;
  margin-bottom: 1.5rem;
}

.policy-details h3 {
  color: #2c3e50;
  font-size: 1.25rem;
  margin-bottom: 1rem;
  font-weight: 600;
}

.policy-value {
  font-size: 1.75rem;
  font-weight: 700;
  color: #3498db;
  margin-bottom: 0.5rem;
}

.policy-description {
  color: #7f8c8d;
  font-size: 0.95rem;
  line-height: 1.5;
  margin-bottom: 0;
}

.policy-notes {
  background: #f8f9fa;
  border-radius: 8px;
  overflow: hidden;
  border-left: 4px solid #3498db;
}

.note-header {
  background: #eaf2f8;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #dee2e6;
}

.note-header h3 {
  margin: 0;
  font-size: 1.1rem;
  color: #2c3e50;
  font-weight: 600;
}

.note-header i {
  color: #3498db;
  margin-right: 0.5rem;
}

.note-content {
  padding: 1.5rem;
}

.note-content ul {
  margin: 0;
  padding-left: 1.25rem;
}

.note-content li {
  margin-bottom: 0.5rem;
  color: #555;
}

.btn-primary {
  background-color: #3498db;
  border-color: #3498db;
  padding: 0.5rem 1.25rem;
  font-weight: 500;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
}

.btn-primary:hover {
  background-color: #2980b9;
  border-color: #2980b9;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-primary i {
  margin-right: 0.5rem;
}

@media (max-width: 768px) {
  .policy-card-container {
    grid-template-columns: 1fr;
  }

  .d-flex {
    flex-direction: column;
    align-items: flex-start;
  }

  .btn-primary {
    margin-top: 1rem;
  }
}
</style>
@endsection
