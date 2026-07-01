<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - HEAN Admin</title>

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

        .verify-container {
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

        .verify-container:hover {
            transform: translateY(-4px);
        }

        /* Decorative top bar */
        .verify-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0EA5E9, #3B82F6, #10B981);
        }

        /* Logo */
        .verify-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .verify-logo img {
            height: 60px;
            margin-bottom: 12px;
        }

        .verify-logo h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .verify-logo h1 span {
            color: #0EA5E9;
        }

        .verify-logo p {
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

        /* Success Alert */
        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            border-left: 4px solid #16a34a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success i {
            font-size: 1.2rem;
        }

        /* Buttons Container */
        .verify-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }

        .verify-actions .btn-resend {
            padding: 12px 28px;
            background: linear-gradient(135deg, #0EA5E9, #3B82F6);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
        }

        .verify-actions .btn-resend:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        }

        .verify-actions .btn-resend:active {
            transform: scale(0.98);
        }

        .verify-actions .btn-logout {
            padding: 12px 24px;
            background: transparent;
            color: #64748b;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .verify-actions .btn-logout:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        /* Footer */
        .verify-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .verify-footer a {
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
        }

        .verify-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .verify-container {
                padding: 32px 24px;
            }
            .verify-logo img {
                height: 50px;
            }
            .verify-logo h1 {
                font-size: 1.7rem;
            }
            .verify-actions {
                flex-direction: column;
            }
            .verify-actions .btn-resend,
            .verify-actions .btn-logout {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="verify-container">

        <!-- Logo -->
        <div class="verify-logo">
            <img src="{{ asset('images/logo.png') }}" alt="HEAN Logo">
            <h1>HEAN<span>.</span></h1>
            <p>Hostel Entrepreneur Association of Nepal</p>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <i class="fas fa-envelope"></i>
            <p>
                <strong>Verify Your Email</strong><br>
                Before getting started, please verify your email address by clicking the link we just sent to your inbox. If you didn't receive the email, we'll send you another one.
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status') == 'verification-link-sent')
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <div>A new verification link has been sent to your email address.</div>
            </div>
        @endif

        <!-- Actions -->
        <div class="verify-actions">
            <!-- Resend Form -->
            <form method="POST" action="{{ route('verification.send') }}" style="flex:1;">
                @csrf
                <button type="submit" class="btn-resend">
                    <i class="fas fa-paper-plane"></i> Resend Verification Email
                </button>
            </form>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="verify-footer">
            &copy; {{ date('Y') }} <a href="{{ route('home') }}">HEAN</a>. All rights reserved.
        </div>

    </div>

</body>
</html>