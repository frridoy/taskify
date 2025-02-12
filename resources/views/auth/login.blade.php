<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
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
            background-color: #f3f4f6;
            color: #1f2937;
            line-height: 1.5;
        }

        /* Login Container */
        .login-container {
            min-height: 100vh;
            display: flex;
        }

        /* Left Banner Section */
        .login-banner {
            display: none;
            position: relative;
            background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
            overflow: hidden;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            padding: 4rem;
            color: white;
        }

        .banner-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0);
            background-size: 20px 20px;
        }

        /* Form Section */
        .form-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background-color: white;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.6s ease-out;
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-section img {
            height: 3rem;
            margin-bottom: 1rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s;
            background-color: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Remember Me & Forgot Password */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-checkbox {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            accent-color: #3b82f6;
        }

        .forgot-password {
            color: #3b82f6;
            font-size: 0.875rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #2563eb;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background-color: #2563eb;
        }

        .submit-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        /* Error Messages */
        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.25rem;
        }

        .register-link a:hover {
            color: #2563eb;
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

        /* Responsive Design */
        @media (min-width: 1024px) {
            .login-banner {
                display: block;
                width: 50%;
            }

            .form-container {
                width: 50%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Banner -->
        <div class="login-banner">
            <div class="banner-content">
                <h1 class="text-3xl font-bold mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                <p class="text-lg text-blue-100">Access your account to manage your dashboard and settings.</p>
            </div>
            <div class="banner-pattern"></div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="form-box">
                <!-- Logo Section -->
                <div class="logo-section">
                    <h1 class="text-2xl font-bold mb-2">Sign In</h1>
                    <p class="text-gray-600">Please enter your credentials</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
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
    </div>
</body>
</html>
