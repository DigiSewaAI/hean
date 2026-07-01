<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - HEAN Admin</title>

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
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .reset-container:hover {
            transform: translateY(-4px);
        }

        /* Decorative top bar */
        .reset-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0EA5E9, #3B82F6, #10B981);
        }

        /* Logo */
        .reset-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .reset-logo img {
            height: 60px;
            margin-bottom: 12px;
        }

        .reset-logo h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .reset-logo h1 span {
            color: #0EA5E9;
        }

        .reset-logo p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 4px;
            font-weight: 500;
        }

        /* Info Box */
        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box i {
            color: #0EA5E9;
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .info-box p {
            color: #0c4a6e;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Error Alert */
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger i {
            font-size: 1.2rem;
        }

        /* Form */
        .reset-form .form-group {
            margin-bottom: 20px;
        }

        .reset-form label {
            display: block;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .reset-form .input-group {
            position: relative;
        }

        .reset-form .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .reset-form .input-group input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
        }

        .reset-form .input-group input:focus {
            border-color: #0EA5E9;
            outline: none;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .reset-form .input-group input:focus ~ i {
            color: #0EA5E9;
        }

        /* Reset Button */
        .btn-reset {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0EA5E9, #3B82F6);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        }

        .btn-reset:active {
            transform: scale(0.98);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #0284C7;
        }

        /* Footer */
        .reset-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .reset-footer a {
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
        }

        .reset-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .reset-container {
                padding: 32px 24px;
            }
            .reset-logo img {
                height: 50px;
            }
            .reset-logo h1 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>

    <div class="reset-container">

        <!-- Logo -->
        <div class="reset-logo">
            <img src="{{ asset('images/logo.png') }}" alt="HEAN Logo">
            <h1>HEAN<span>.</span></h1>
            <p>Hostel Entrepreneur Association of Nepal</p>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <i class="fas fa-key"></i>
            <p>
                <strong>Reset Your Password</strong><br>
                Please enter your email and choose a new password. Make sure it's strong and unique.
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reset Form -->
        <form class="reset-form" method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope" style="color:#0EA5E9; margin-right:6px;"></i> Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="admin@hean.com">
                </div>
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label for="password"><i class="fas fa-lock" style="color:#0EA5E9; margin-right:6px;"></i> New Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" required autocomplete="new-password" placeholder="••••••••">
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation"><i class="fas fa-check-circle" style="color:#0EA5E9; margin-right:6px;"></i> Confirm Password</label>
                <div class="input-group">
                    <i class="fas fa-check-circle"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                </div>
            </div>

            <!-- Reset Button -->
            <button type="submit" class="btn-reset">
                <i class="fas fa-sync-alt"></i> Reset Password
            </button>

            <div class="back-link">
                <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </div>
        </form>

        <!-- Footer -->
        <div class="reset-footer">
            &copy; {{ date('Y') }} <a href="{{ route('home') }}">HEAN</a>. All rights reserved.
        </div>

    </div>

</body>
</html>