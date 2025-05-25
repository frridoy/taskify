{{--
<form id="monthYearForm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Select Month & Year</h5>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label for="month">Month</label>
                <select name="month" id="month" class="form-control" required>
                    @foreach(config('static_array.months') as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="year">Year</label>
                <select name="year" id="year" class="form-control" required>
                    @for ($i = now()->year - 1; $i <= now()->year + 1; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="continueBtn" class="btn btn-success">Continue</button>
        </div>
    </div>
</form>
<script>
    document.getElementById('continueBtn').addEventListener('click', function () {
        let month = document.getElementById('month').value;
        let year = document.getElementById('year').value;

        if (month && year) {
            window.location.href = `/employee-salaries/${month}/${year}`;
        }
    });
</script>
 --}}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Month & Year</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .modal-container {
            max-width: 500px;
            width: 100%;
            animation: fadeInUp 0.5s;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            position: relative;
        }

        .modal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-color);
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .modal-body {
            padding: 2rem;
            background-color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }

        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .btn-success {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: none;
            padding: 1.5rem;
            display: flex;
            justify-content: flex-end;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .select-icon {
            position: relative;
        }

        .select-icon::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--dark-color);
        }
    </style>
</head>
<body>
    <div class="container modal-container">
        <form id="monthYearForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-alt me-2"></i>Select Month & Year</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4 select-icon">
                        <label for="month"><i class="fas fa-month me-2"></i>Month</label>
                        <select name="month" id="month" class="form-control form-select" required>
                            @foreach(config('static_array.months') as $key => $value)
                                <option value="{{ $key }}" {{ $key == now()->month ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4 select-icon">
                        <label for="year"><i class="fas fa-calendar me-2"></i>Year</label>
                        <select name="year" id="year" class="form-control form-select" required>
                            @for ($i = now()->year - 1; $i <= now()->year + 1; $i++)
                                <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="continueBtn" class="btn btn-success">
                        <i class="fas fa-arrow-right me-2"></i>Continue
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('continueBtn').addEventListener('click', function () {
            let month = document.getElementById('month').value;
            let year = document.getElementById('year').value;

            if (month && year) {
                document.querySelector('.modal-content').style.transform = 'scale(0.95)';
                document.querySelector('.modal-content').style.opacity = '0.8';

                setTimeout(() => {
                    window.location.href = `/employee-salaries/${month}/${year}`;
                }, 300);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.form-control');
            selects.forEach((select, index) => {
                setTimeout(() => {
                    select.style.opacity = '1';
                    select.style.transform = 'translateY(0)';
                }, index * 100 + 500);
            });
        });
    </script>
</body>
</html>

