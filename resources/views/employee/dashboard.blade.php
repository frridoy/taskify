@extends('admin.layouts.app')
@section('content')
    <style>
        /* Previous styles remain the same until card-specific styles */
        .dashboard-container {
            background: #f8fafc;
            min-height: 100vh;
            padding: 1.5rem;
        }

        .dashboard-header {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
        }

        .dashboard-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .dashboard-subtitle {
            color: #64748b;
            font-size: 0.875rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            height: 100%;
        }

        /* Keep hover effect */
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .stat-description {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 0.75rem;
        }

        .stat-trend {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #f1f5f9;
        }

        .stat-icon i {
            font-size: 1.25rem;
            color: white;
        }

        /* Keep gradients and color classes the same */
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 12px 12px 0 0;
        }

        .stat-card.total::after {
            background: linear-gradient(to right, #4f46e5, #6366f1);
        }

        .stat-card.pending::after {
            background: linear-gradient(to right, #f59e0b, #fbbf24);
        }

        .stat-card.processing::after {
            background: linear-gradient(to right, #0ea5e9, #38bdf8);
        }

        .stat-card.completed::after {
            background: linear-gradient(to right, #10b981, #34d399);
        }

        .stat-card.missed::after {
            background: linear-gradient(to right, #ef4444, #f87171);
        }

        .stat-card.missed2::after {
            background: linear-gradient(to right, #efe944, #f8e671);
        }

        .stat-card.upcoming::after {
            background: linear-gradient(to right, #8b5cf6, #a78bfa);
        }

        .total .stat-icon {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
        }

        .pending .stat-icon {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .processing .stat-icon {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        }

        .completed .stat-icon {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .missed .stat-icon {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }

        .missed2 .stat-icon {
            background: linear-gradient(135deg, #b7a416, #dbf871);
        }

        .upcoming .stat-icon {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        }

        .trend-up {
            color: #10b981;
        }

        .trend-down {
            color: #ef4444;
        }
    </style>

    <!-- Keep the same HTML structure but with updated content -->
    <div class="dashboard-container">


        <div class="stats-grid">
            <!-- Total Tasks -->
            <a href="{{ route('my.tasks') }}" class="stat-card total">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
                <div class="stat-label">Total Tasks</div>
                <div class="stat-value">{{ $total_tasks }}</div>
                <div class="stat-description">All tasks assigned to you</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up me-1 trend-up"></i>
                    <span>5% vs last week</span>
                </div>
            </a>

            <!-- Pending Tasks -->
            <a href="{{ route('pending_tasks') }}" class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-label">Pending Tasks</div>
                <div class="stat-value">{{ $pending_tasks_count }}</div>
                <div class="stat-description">Tasks yet to be started</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-down me-1 trend-down"></i>
                    <span>2% vs last week</span>
                </div>
            </a>

            <!-- Processing Tasks -->
            <a href="{{ route('processing_tasks') }}" class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
                <div class="stat-label">Processing Tasks</div>
                <div class="stat-value">{{ $processing_tasks_count }}</div>
                <div class="stat-description">Tasks in progress</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up me-1 trend-up"></i>
                    <span>12% vs last week</span>
                </div>
            </a>

            <!-- Completed Tasks -->
            <a href="{{ route('completed_tasks') }}" class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-label">Completed Tasks</div>
                <div class="stat-value">{{ $completed_tasks_count }}</div>
                <div class="stat-description">Successfully completed tasks</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up me-1 trend-up"></i>
                    <span>8% vs last week</span>
                </div>
            </a>

            <!-- Missed Tasks -->
            <div class="stat-card missed2">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-label">Missed Pending Tasks</div>
                <div class="stat-value">{{ $missed_pending_tasks }}</div>
                <div class="stat-description">Tasks that missed deadline</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-down me-1 trend-down"></i>
                    <span>3% vs last week</span>
                </div>
            </div>

            <!-- Upcoming Tasks -->
            <div class="stat-card missed">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-label">Missed Processing Tasks</div>
                <div class="stat-value">{{ $missed_processing_tasks }}</div>
                <div class="stat-description">Tasks due this week</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-down me-1 trend-down"></i>
                    <span>3% vs last week</span>
                </div>
            </div>

            <div class="stat-card missed">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
                <div class="stat-label">Task Status for {{ \Carbon\Carbon::now()->format('F Y') }}</div>
                <div class="stat-value" style="height: 100px; position: relative;">
                    <canvas id="miniPieChart" style="width: 100px; height: 100px;"></canvas>
                </div>

                <div class="stat-description">
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="d-flex align-items-center">
                            <span class="legend-dot bg-danger me-1"></span>
                            <small>Pending: {{ $pendingTasks }}</small>
                        </span>
                        <span class="d-flex align-items-center">
                            <span class="legend-dot bg-primary me-1"></span>
                            <small>Processing: {{ $processingTasks }}</small>
                        </span>
                        <span class="d-flex align-items-center">
                            <span class="legend-dot bg-success me-1"></span>
                            <small>Completed: {{ $completedTasks }}</small>
                        </span>
                    </div>
                </div>

                <div class="stat-trend">
                    <span>Total: {{ $pendingTasks + $processingTasks + $completedTasks }} tasks for
                        {{ auth()->user()->name }} only</span>
                </div>

            </div>

            <style>
                .legend-dot {
                    display: inline-block;
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                }
            </style>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('miniPieChart').getContext('2d');
                    const total = {{ $pendingTasks + $processingTasks + $completedTasks }};

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Pending', 'Processing', 'Completed'],
                            datasets: [{
                                data: [{{ $pendingTasks }}, {{ $processingTasks }},
                                    {{ $completedTasks }}
                                ],
                                backgroundColor: [
                                    'rgba(220, 53, 69, 0.8)',
                                    'rgba(13, 110, 253, 0.8)',
                                    'rgba(25, 135, 84, 0.8)'
                                ],
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            const percentage = Math.round((value / total) * 100);
                                            return `${label}: ${percentage}% (${value})`;
                                        }
                                    }
                                }
                            },
                            cutout: '60%',
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            }
                        }
                    });
                });
            </script>
        </div>

    </div>
@endsection
