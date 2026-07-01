<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - HEAN Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .forgot-container {
            max-width: 440px;
            width: 100%;
            background: #fff;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        .forgot-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0EA5E9, #3B82F6, #10B981);
        }
        .forgot-logo { text-align: center; margin-bottom: 28px; }
        .forgot-logo img { height: 50px; margin-bottom: 10px; }
        .forgot-logo h1 { font-size: 1.8rem; font-weight: 800; color: #0f172a; }
        .forgot-logo h1 span { color: #0EA5E9; }
        .forgot-logo p { color: #64748b; font-size: 0.9rem; margin-top: 4px; }
        .forgot-desc { color: #475569; font-size: 0.95rem; text-align: center; margin-bottom: 24px; line-height: 1.7; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #0f172a; margin-bottom: 6px; font-size: 0.9rem; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .input-group input {
            width: 100%; padding: 14px 18px 14px 48px;
            border: 2px solid #e2e8f0; border-radius: 12px;
            font-size: 1rem; background: #f8fafc;
            transition: 0.3s;
        }
        .input-group input:focus { border-color: #0EA5E9; outline: none; box-shadow: 0 0 0 4px rgba(14,165,233,0.1); background: #fff; }
        .btn-submit {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #0EA5E9, #3B82F6);
            color: #fff; border: none; border-radius: 50px;
            font-size: 1rem; font-weight: 700; cursor: pointer;
            transition: 0.2s; box-shadow: 0 4px 15px rgba(14,165,233,0.3);
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(14,165,233,0.4); }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #0EA5E9; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .back-link a:hover { text-decoration: underline; }
        .alert-success { background: #f0fdf4; color: #16a34a; padding: 12px 16px; border-radius: 12px; border-left: 4px solid #16a34a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-danger { background: #fef2f2; color: #dc2626; padding: 12px 16px; border-radius: 12px; border-left: 4px solid #dc2626; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        @media (max-width: 480px) {
            .forgot-container { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <div class="forgot-container">
        <div class="forgot-logo">
            <img src="{{ asset('images/logo.png') }}" alt="HEAN">
            <h1>HEAN<span>.</span></h1>
            <p>Reset Password</p>
        </div>

        @if(session('status'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <p class="forgot-desc">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope" style="color:#0EA5E9; margin-right:6px;"></i> Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="admin@hean.com">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Email Password Reset Link
            </button>

            <div class="back-link">
                <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </div>
        </form>
    </div>

</body>
</html>