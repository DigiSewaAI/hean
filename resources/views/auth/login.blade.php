<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.hero_badge') }} - Login</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            padding: 50px 40px;
            width: 100%;
            max-width: 440px;
            position: relative;
            overflow: hidden;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: -60%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(14,165,233,0.06) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo img {
            height: 60px;
            margin-bottom: 10px;
        }
        .login-logo h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #0f172a;
        }
        .login-logo h1 span {
            color: #0EA5E9;
        }
        .login-logo p {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 6px;
        }
        .login-form .form-group {
            margin-bottom: 20px;
        }
        .login-form label {
            display: block;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }
        .login-form input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: border 0.3s, box-shadow 0.3s;
            background: #f8fafc;
        }
        .login-form input:focus {
            border-color: #0EA5E9;
            outline: none;
            box-shadow: 0 0 0 4px rgba(14,165,233,0.1);
            background: #fff;
        }
        .login-form .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0EA5E9, #0284C7);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 25px rgba(14,165,233,0.3);
        }
        .login-form .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(14,165,233,0.4);
        }
        .login-form .btn-login:active {
            transform: scale(0.98);
        }
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .login-footer a {
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .input-icon input {
            padding-left: 46px;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #0EA5E9;
            border-radius: 4px;
            cursor: pointer;
        }
        .remember-me label {
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
        }
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            .login-logo img {
                height: 50px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <div class="login-logo">
            <img src="{{ asset('images/logo.png') }}" alt="HEAN">
            <h1>HEAN<span>.</span></h1>
            <p>Hostel Entrepreneur Association of Nepal</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> {{ __('messages.contact_email') }}</label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                </div>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" required placeholder="••••••••">
                </div>
            </div>

            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div class="login-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            <p style="margin-top: 8px; font-size: 0.75rem; color: #cbd5e1;">
                Demo: admin@hean.com / password
            </p>
        </div>
    </div>

</body>
</html>