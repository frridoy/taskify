<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Taskify - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            line-height: 1.5;
            background-color: #b3e5fc;
            overflow-x: hidden;
        }

        /* Background Pattern with Task Symbols */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #b3e5fc;
            z-index: -2;
        }

        .symbol {
            position: absolute;
            opacity: 0.12;
            transform-origin: center;
        }

        .symbol svg {
            width: 100%;
            height: 100%;
        }

        .symbol-check {
            width: 40px;
            height: 40px;
            fill: #22c55e;
        }

        .symbol-clipboard {
            width: 50px;
            height: 50px;
            fill: #ff7b54;
        }

        .symbol-calendar {
            width: 45px;
            height: 45px;
            fill: #3b82f6;
        }

        .symbol-task {
            width: 42px;
            height: 42px;
            fill: #6366f1;
        }

        .symbol-clock {
            width: 38px;
            height: 38px;
            fill: #8b5cf6;
        }

        .symbol-note {
            width: 48px;
            height: 48px;
            fill: #06b6d4;
        }

        /* Login Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        /* Company Logo */
        .company-logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            display: none;
        }

        .company-logo svg {
            height: 2.5rem;
            fill: #0284c7;
        }

        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 440px;
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            animation: fadeIn 0.5s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .taskify-logo {
            margin-bottom: 1.2rem;
            display: inline-block;
        }

        .taskify-logo svg {
            height: 2.8rem;
            fill: #0284c7;
        }

        .logo-section h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .logo-section p {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1.2rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background-color: rgba(255, 255, 255, 0.8);
            color: #334155;
        }

        .form-input:focus {
            outline: none;
            border-color: #0ea5e9;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        /* Remember Me & Forgot Password */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-checkbox {
            width: 1.1rem;
            height: 1.1rem;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            accent-color: #0ea5e9;
        }

        .forgot-password {
            color: #0ea5e9;
            font-size: 0.875rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #0284c7;
            text-decoration: underline;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 0.9rem 1rem;
            background-color: #0ea5e9;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.02em;
        }

        .submit-btn:hover {
            background-color: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .submit-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .status-message {
            padding: 0.75rem;
            background-color: #ecfdf5;
            border-radius: 8px;
            color: #047857;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .register-link a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.25rem;
        }

        .register-link a:hover {
            color: #0284c7;
            text-decoration: underline;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-15px) rotate(5deg);
            }
            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .company-logo {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Background Pattern with Task Symbols -->
    <div class="bg-pattern" id="bg-pattern"></div>

    <!-- Company Logo -->
    <div class="company-logo">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
    </div>

    <div class="login-container">
        <!-- Form Container -->
        <div class="form-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="taskify-logo">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3H5C3.89 3 3 3.9 3 5V19C3 20.1 3.89 21 5 21H19C20.11 21 21 20.1 21 19V5C21 3.9 20.11 3 19 3ZM10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"></path>
                    </svg>
                </div>
                <h1>Taskify</h1>
                <p>Enter your credentials to access your workspace</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="form-input"
                        placeholder="name@example.com"
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="form-input"
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-footer">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" class="remember-checkbox">
                        <label for="remember" class="text-sm text-gray-600">Remember me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    Sign in
                </button>
            </form>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="register-link">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create one now</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Create task-related symbols for the background
        document.addEventListener('DOMContentLoaded', function() {
            const bgPattern = document.getElementById('bg-pattern');
            const symbols = [
                { class: 'symbol-check', svg: '<svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>' },
                { class: 'symbol-clipboard', svg: '<svg viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>' },
                { class: 'symbol-calendar', svg: '<svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>' },
                { class: 'symbol-task', svg: '<svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>' },
                { class: 'symbol-clock', svg: '<svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>' },
                { class: 'symbol-note', svg: '<svg viewBox="0 0 24 24"><path d="M19 3H4.99C3.89 3 3 3.9 3 5l.01 14c0 1.1.89 2 1.99 2h10.01c.45 0 .85-.15 1.19-.4l3.79-3.79c.25-.35.4-.75.4-1.19V5c0-1.1-.9-2-2-2zm-7 11H7v-2h5v2zm5-4H7V8h10v2z"/></svg>' }
            ];

            // Create 30 symbols randomly positioned on the screen
            for (let i = 0; i < 30; i++) {
                const symbolDiv = document.createElement('div');
                const randomSymbol = symbols[Math.floor(Math.random() * symbols.length)];

                symbolDiv.className = 'symbol ' + randomSymbol.class;
                symbolDiv.innerHTML = randomSymbol.svg;

                // Random position
                const randomX = Math.random() * 100;
                const randomY = Math.random() * 100;

                // Random rotation
                const randomRotation = Math.random() * 40 - 20;

                // Random animation delay
                const randomDelay = Math.random() * 5;

                symbolDiv.style.left = randomX + 'vw';
                symbolDiv.style.top = randomY + 'vh';
                symbolDiv.style.transform = 'rotate(' + randomRotation + 'deg)';
                symbolDiv.style.animation = 'float ' + (5 + Math.random() * 5) + 's ease-in-out infinite';
                symbolDiv.style.animationDelay = randomDelay + 's';

                bgPattern.appendChild(symbolDiv);
            }
        });
    </script>
</body>
</html>
