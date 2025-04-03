@extends('setup.master')
@section('content')
<!-- Previous styles remain the same -->
<style>
/* Previous styles remain unchanged */

/* Add new styles for the graph section */
.graph-container {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-top: 1rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.graph-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.graph-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
}

.graph-legend {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.graph-grid {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 1rem;
    padding-right: 1rem;
}

.y-axis {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: right;
    color: #94a3b8;
    font-size: 0.75rem;
    padding-right: 1rem;
}

.graph-bars {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    height: 200px;
    position: relative;
}

.graph-bars::before {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: linear-gradient(to right, #f1f5f9 1px, transparent 1px) 0 0 / 50px 40px;
    opacity: 0.5;
}

.bar-group {
    display: flex;
    gap: 4px;
    flex: 1;
    align-items: flex-end;
}

.bar {
    flex: 1;
    border-radius: 4px 4px 0 0;
    transition: all 0.3s ease;
}

.bar:hover {
    opacity: 0.8;
}

.bar-completed { background: linear-gradient(to top, #10b981, #34d399); }
.bar-target { background: linear-gradient(to top, #6366f1, #818cf8); }

.x-axis {
    display: flex;
    justify-content: space-between;
    color: #64748b;
    font-size: 0.75rem;
    margin-top: 0.5rem;
    padding-left: 2rem;
}

.x-axis-label {
    flex: 1;
    text-align: center;
}
</style>

<!-- Previous dashboard content remains unchanged -->

<!-- Add new graph section -->
<div class="graph-container">
    <div class="graph-header">
        <div class="graph-title">Daily Task Completion</div>
        <div class="graph-legend">
            <div class="legend-item">
                <div class="legend-dot" style="background: #10b981;"></div>
                <span>Completed Tasks</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background: #6366f1;"></div>
                <span>Target Tasks</span>
            </div>
        </div>
    </div>

    <div class="graph-grid">
        <div class="y-axis">
            <div>50</div>
            <div>40</div>
            <div>30</div>
            <div>20</div>
            <div>10</div>
            <div>0</div>
        </div>

        <div>
            <div class="graph-bars">
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 60%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 75%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 85%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 65%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 90%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 70%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
                <div class="bar-group">
                    <div class="bar bar-completed" style="height: 80%;"></div>
                    <div class="bar bar-target" style="height: 80%;"></div>
                </div>
            </div>
            <div class="x-axis">
                <div class="x-axis-label">Mon</div>
                <div class="x-axis-label">Tue</div>
                <div class="x-axis-label">Wed</div>
                <div class="x-axis-label">Thu</div>
                <div class="x-axis-label">Fri</div>
                <div class="x-axis-label">Sat</div>
                <div class="x-axis-label">Sun</div>
            </div>
        </div>
    </div>
</div>
@endsection
