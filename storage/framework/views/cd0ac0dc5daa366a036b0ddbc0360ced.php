<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - HEAN Admin</title>

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

        .login-container {
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

        .login-container:hover {
            transform: translateY(-4px);
        }

        /* Decorative top bar */
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0EA5E9, #3B82F6, #10B981);
        }

        /* Logo */
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo img {
            height: 60px;
            margin-bottom: 12px;
        }

        .login-logo h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .login-logo h1 span {
            color: #0EA5E9;
        }

        .login-logo p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 4px;
            font-weight: 500;
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

        .login-form .input-group {
            position: relative;
        }

        .login-form .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .login-form .input-group input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
        }

        .login-form .input-group input:focus {
            border-color: #0EA5E9;
            outline: none;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .login-form .input-group input:focus + i,
        .login-form .input-group input:focus ~ i {
            color: #0EA5E9;
        }

        /* Remember & Forgot */
        .login-form .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .login-form .form-options .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
        }

        .login-form .form-options .remember input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #0EA5E9;
            cursor: pointer;
        }

        .login-form .form-options .forgot a {
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .login-form .form-options .forgot a:hover {
            color: #0284C7;
            text-decoration: underline;
        }

        /* Login Button */
        .login-form .btn-login {
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

        .login-form .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        }

        .login-form .btn-login:active {
            transform: scale(0.98);
        }

        /* Footer */
        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .login-footer a {
            color: #0EA5E9;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 32px 24px;
            }
            .login-logo img {
                height: 50px;
            }
            .login-logo h1 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">

        <!-- Logo -->
        <div class="login-logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="HEAN Logo">
            <h1>HEAN<span>.</span></h1>
            <p>Hostel Entrepreneur Association of Nepal</p>
        </div>

        <!-- Error Messages -->
        <?php if($errors->any()): ?>
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form class="login-form" method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope" style="color:#0EA5E9; margin-right:6px;"></i> Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="admin@hean.com">
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password"><i class="fas fa-lock" style="color:#0EA5E9; margin-right:6px;"></i> Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" required placeholder="••••••••">
                </div>
            </div>

            <!-- Options -->
            <div class="form-options">
                <label class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
                <div class="forgot">
                    <a href="<?php echo e(route('password.request')); ?>">Forgot password?</a>
                </div>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            &copy; <?php echo e(date('Y')); ?> <a href="<?php echo e(route('home')); ?>">HEAN</a>. All rights reserved.
        </div>

    </div>

</body>
</html><?php /**PATH C:\laragon\www\hean\resources\views/auth/login.blade.php ENDPATH**/ ?>