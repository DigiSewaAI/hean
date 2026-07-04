<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', __('messages.home') . ' - HEAN'); ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        /* Reset & Base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            cursor: default;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ====== NAVBAR ====== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.04);
            transition: box-shadow 0.3s;
        }
        .navbar.scrolled {
            box-shadow: 0 4px 30px rgba(0,0,0,0.08);
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Logo */
        .navbar-brand a {
            display: inline-block;
        }
        .navbar-brand img {
            height: 50px;
            width: auto;
        }

        /* Menu */
        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .nav-links {
            display: flex;
            list-style: none;
            gap: 28px;
            margin: 0;
            padding: 0;
        }
        .nav-links li a {
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
            white-space: nowrap;
        }
        .nav-links li a:hover,
        .nav-links li a.active {
            color: #0EA5E9;
        }

        /* Actions */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .auth-links {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .auth-links a {
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s;
            padding: 6px 12px;
            border-radius: 6px;
        }
        .auth-links a:hover {
            color: #0EA5E9;
            background: rgba(14, 165, 233, 0.08);
        }
        .auth-links .register-link {
            background: #0EA5E9;
            color: #fff !important;
            padding: 6px 16px;
            border-radius: 50px;
        }
        .auth-links .register-link:hover {
            background: #0284C7;
            color: #fff !important;
        }

        .language-switcher {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .language-switcher a {
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 4px 8px;
            border-radius: 4px;
            transition: 0.2s;
        }
        .language-switcher a.active {
            background: rgba(14, 165, 233, 0.12);
            color: #0EA5E9;
        }
        .language-switcher .divider {
            color: #cbd5e1;
        }

        .btn-primary-sm {
            padding: 8px 22px;
            border-radius: 50px;
            background: #0EA5E9;
            color: #fff !important;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.3s;
            white-space: nowrap;
        }
        .btn-primary-sm:hover {
            background: #0284C7;
            transform: translateY(-2px);
        }

        /* Mobile toggle */
        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            color: #0f172a;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Mobile */
        @media (max-width: 992px) {
            .navbar-menu {
                display: none;
                flex-direction: column;
                background: #fff;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                padding: 24px 20px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.08);
                border-radius: 0 0 16px 16px;
            }
            .navbar-menu.active {
                display: flex;
            }
            .nav-links {
                flex-direction: column;
                gap: 14px;
            }
            .nav-links li a {
                font-size: 1rem;
            }
            .navbar-actions {
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 16px;
                gap: 12px;
            }
            .auth-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            .navbar-toggle {
                display: block;
            }
            .navbar-brand img {
                height: 40px;
            }
        }

        /* Preloader */
        #preloader {
            position: fixed;
            inset: 0;
            background: #0f172a;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: opacity 0.8s, visibility 0.8s;
        }
        #preloader.hide {
            opacity: 0;
            visibility: hidden;
        }
        #preloader .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(14, 165, 233, 0.2);
            border-top-color: #0EA5E9;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        #preloader .text {
            margin-top: 16px;
            color: #f8fafc;
            font-weight: 500;
            letter-spacing: 2px;
        }

        /* Scroll progress */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #0EA5E9, #10B981);
            z-index: 9999;
            width: 0%;
            transition: width 0.1s;
        }

        /* ====== FOOTER STYLES ====== */
        .footer a {
            transition: color 0.3s;
        }
        .footer a:hover {
            color: #0EA5E9 !important;
        }

        /* Footer bottom row: copyright left, tech partner right */
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            font-size: 0.85rem;
        }

        .footer-bottom .copyright {
            color: #94a3b8;
            text-align: left;
        }

        .footer-bottom .copyright a {
            color: #94a3b8;
            text-decoration: none;
        }
        .footer-bottom .copyright a:hover {
            color: #0EA5E9;
        }

        .footer-bottom .tech-partner {
            color: #94a3b8;
            text-align: right;
            white-space: nowrap;
        }

        .footer-bottom .tech-partner a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .footer-bottom .tech-partner a:hover {
            color: #0EA5E9;
        }

        @media (max-width: 768px) {
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            .footer-bottom .copyright {
                text-align: center;
            }
            .footer-bottom .tech-partner {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
        <div class="text"><?php echo e(__('messages.hero_badge')); ?></div>
    </div>

    <!-- Scroll Progress -->
    <div id="scroll-progress"></div>

    <!-- ====== NAVBAR ====== -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="navbar-brand" style="display:flex; align-items:center; gap:12px;">
    <a href="<?php echo e(route('home')); ?>">
    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="HEAN" style="height:75px; width:auto;">
</a>
    <div style="display:flex; flex-direction:column; line-height:1.2;">
        <span style="font-size:14px; font-weight:700; color:#0b2b4a;">होस्टल व्यवसायी संघ</span>
        <span style="font-size:10px; font-weight:600; color:#1e5f8e;">Hostel Entrepreneur Association of Nepal (HEAN)</span>
    </div>
</div>

            <div class="navbar-menu" id="navbarMenu">
                <ul class="nav-links">
                    <li><a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.home'); ?></a></li>
                    <li><a href="<?php echo e(route('about')); ?>" class="<?php echo e(request()->routeIs('about') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.about'); ?></a></li>
                    <li><a href="<?php echo e(route('hostels.index')); ?>" class="<?php echo e(request()->routeIs('hostels.*') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.hostels'); ?></a></li>
                    <li><a href="<?php echo e(route('committee.index')); ?>" class="<?php echo e(request()->routeIs('committee.*') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.committee'); ?></a></li>
                    <li><a href="<?php echo e(route('notices.index')); ?>" class="<?php echo e(request()->routeIs('notices.*') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.notices'); ?></a></li>
                    <li><a href="<?php echo e(route('gallery.index')); ?>" class="<?php echo e(request()->routeIs('gallery.*') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.gallery'); ?></a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="<?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>"><?php echo app('translator')->get('messages.contact'); ?></a></li>
                </ul>

                <div class="navbar-actions">
                    <div class="auth-links">
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('login')); ?>"><?php echo app('translator')->get('messages.login'); ?></a>
                            
                        <?php else: ?>
                            <?php if(auth()->user()->role == 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" style="color:#0EA5E9;"><?php echo app('translator')->get('messages.admin_dashboard'); ?></a>
                            <?php endif; ?>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" style="background:none; border:none; color:#1e293b; font-weight:500; cursor:pointer; font-size:0.9rem; padding:6px 12px;"><?php echo app('translator')->get('messages.logout'); ?></button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="language-switcher">
                        <a href="<?php echo e(route('lang.switch', 'en')); ?>" class="<?php echo e(app()->getLocale() == 'en' ? 'active' : ''); ?>">EN</a>
                        <span class="divider">|</span>
                        <a href="<?php echo e(route('lang.switch', 'ne')); ?>" class="<?php echo e(app()->getLocale() == 'ne' ? 'active' : ''); ?>">नेपाली</a>
                    </div>

                    
                </div>
            </div>

            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- ====== MAIN CONTENT ====== -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- ====== FOOTER ====== -->
    <footer class="footer" style="background:#0f172a; color:#94a3b8; padding:60px 0 30px; margin-top:0;">
        <div class="container">

            <!-- Footer Grid -->
            <div class="footer-grid" style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:40px;">
                <!-- Brand Column -->
                <div>
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
<img src="<?php echo e(asset('images/logo.png')); ?>" alt="HEAN Logo" style="height:80px; width:auto;">
        <div style="display:flex; flex-direction:column; line-height:1.2;">
            <span style="font-size:12px; font-weight:700; color:#ffffff;">होस्टल व्यवसायी संघ</span>
            <span style="font-size:9px; font-weight:600; color:#94a3b8;">Hostel Entrepreneur Association of Nepal (HEAN)</span>
        </div>
    </div>
    <p style="margin-top:12px; font-size:0.95rem; line-height:1.7;"><?php echo app('translator')->get('messages.footer_about'); ?></p>
    <!-- Social Icons (पहिले जस्तै) -->
    <div style="display:flex; gap:14px; margin-top:20px;">
        <a href="https://www.facebook.com/hostelentrepreneurassociationofnepalHEAN" target="_blank" rel="noopener" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-facebook-f"></i></a>
        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-twitter"></i></a>
        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-instagram"></i></a>
        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-linkedin-in"></i></a>
    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 style="color:#f8fafc; font-weight:600; margin-bottom:20px;"><?php echo app('translator')->get('messages.footer_quick_links'); ?></h4>
                    <ul style="list-style:none; padding:0;">
                        <li style="margin-bottom:10px;"><a href="<?php echo e(route('home')); ?>" style="color:#94a3b8; text-decoration:none; transition:0.2s;"><?php echo app('translator')->get('messages.home'); ?></a></li>
                        <li style="margin-bottom:10px;"><a href="<?php echo e(route('about')); ?>" style="color:#94a3b8; text-decoration:none; transition:0.2s;"><?php echo app('translator')->get('messages.about'); ?></a></li>
                        <li style="margin-bottom:10px;"><a href="<?php echo e(route('hostels.index')); ?>" style="color:#94a3b8; text-decoration:none; transition:0.2s;"><?php echo app('translator')->get('messages.hostels'); ?></a></li>
                        <li style="margin-bottom:10px;"><a href="<?php echo e(route('committee.index')); ?>" style="color:#94a3b8; text-decoration:none; transition:0.2s;"><?php echo app('translator')->get('messages.committee'); ?></a></li>
                        <li style="margin-bottom:10px;"><a href="<?php echo e(route('notices.index')); ?>" style="color:#94a3b8; text-decoration:none; transition:0.2s;"><?php echo app('translator')->get('messages.notices'); ?></a></li>
                        <li style="margin-bottom:10px;"><a href="<?php echo e(route('gallery.index')); ?>" style="color:#94a3b8; text-decoration:none; transition:0.2s;"><?php echo app('translator')->get('messages.gallery'); ?></a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 style="color:#f8fafc; font-weight:600; margin-bottom:20px;"><?php echo app('translator')->get('messages.footer_contact'); ?></h4>
                    <ul style="list-style:none; padding:0;">
                        <li style="margin-bottom:10px;"><i class="fas fa-map-marker-alt" style="color:#0EA5E9; width:20px;"></i> <?php echo app('translator')->get('messages.footer_address'); ?></li>
                        <li style="margin-bottom:10px;"><i class="fas fa-phone" style="color:#0EA5E9; width:20px;"></i> <?php echo app('translator')->get('messages.footer_phone'); ?></li>
                        <li style="margin-bottom:10px;"><i class="fas fa-envelope" style="color:#0EA5E9; width:20px;"></i> <?php echo app('translator')->get('messages.footer_email'); ?></li>
                        <li style="margin-bottom:10px;"><i class="fas fa-clock" style="color:#0EA5E9; width:20px;"></i> <?php echo app('translator')->get('messages.footer_office_hours'); ?></li>
                    </ul>
                </div>

                <!-- Newsletter Column -->
                <div>
                    <h4 style="color:#f8fafc; font-weight:600; margin-bottom:20px;"><?php echo app('translator')->get('messages.footer_newsletter'); ?></h4>
                    <p style="font-size:0.9rem; margin-bottom:15px;"><?php echo app('translator')->get('messages.footer_newsletter_desc'); ?></p>
                    <form>
                        <input type="email" placeholder="<?php echo app('translator')->get('messages.footer_newsletter_placeholder'); ?>" style="width:100%; padding:10px 14px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); color:#fff; margin-bottom:10px;">
                        <button type="submit" style="background:#0EA5E9; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;"><?php echo app('translator')->get('messages.footer_newsletter_button'); ?></button>
                    </form>
                </div>
            </div>

            <!-- ====== FOOTER BOTTOM ROW ====== -->
            <!-- Copyright (left) | Technology Partner (right, white) -->
            <div class="footer-bottom">
                <div class="copyright">
                    <?php $year = date('Y'); ?>
                    <?php echo app('translator')->get('messages.footer_copyright', ['year' => $year]); ?>
                    &nbsp;|&nbsp;
                    <a href="#"><?php echo app('translator')->get('messages.footer_privacy'); ?></a>
                    &nbsp;|&nbsp;
                    <a href="#"><?php echo app('translator')->get('messages.footer_terms'); ?></a>
                </div>

                <div class="tech-partner">
                    <?php echo app('translator')->get('messages.footer_tech_partner'); ?>
                    <a href="https://www.hostelhubnepal.com" target="_blank" rel="noopener">
                        🏨 <?php echo e(__('messages.footer_tech_partner_name')); ?>

                    </a>
                </div>
            </div>

        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(function() {
                    preloader.classList.add('hide');
                }, 600);
            }
        });

        // Navbar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('navbarToggle');
            const menu = document.getElementById('navbarMenu');
            if (toggle && menu) {
                toggle.addEventListener('click', function() {
                    menu.classList.toggle('active');
                });
                document.addEventListener('click', function(e) {
                    if (menu.classList.contains('active') && !menu.contains(e.target) && !toggle.contains(e.target)) {
                        menu.classList.remove('active');
                    }
                });
            }
        });

        // Scroll progress
        window.addEventListener('scroll', function() {
            const progress = document.getElementById('scroll-progress');
            if (progress) {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const percent = (scrollTop / docHeight) * 100;
                progress.style.width = percent + '%';
            }
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\hean\resources\views/layouts/public.blade.php ENDPATH**/ ?>