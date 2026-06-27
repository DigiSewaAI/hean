<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.home') . ' - HEAN')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

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

        /* Logo - increased by ~10% (45px → 50px) */
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
            color: #0EA5E9; /* Sky Blue */
        }

        /* Actions */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        /* Auth links (Login / Register) */
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
            /* Mobile मा logo size adjust */
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
    </style>
</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
        <div class="text">{{ __('messages.hero_badge') }}</div>
    </div>

    <!-- Scroll Progress -->
    <div id="scroll-progress"></div>

    <!-- ====== NAVBAR ====== -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="{{ route('home') }}">
                    <!-- ✅ Header Logo: height 50px (10% increase from 45px) -->
                    <img src="{{ asset('images/logo.png') }}" alt="HEAN" style="height:50px; width:auto;">
                </a>
            </div>

            <div class="navbar-menu" id="navbarMenu">
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">@lang('messages.home')</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">@lang('messages.about')</a></li>
                    <li><a href="{{ route('hostels.index') }}" class="{{ request()->routeIs('hostels.*') ? 'active' : '' }}">@lang('messages.hostels')</a></li>
                    <li><a href="{{ route('committee.index') }}" class="{{ request()->routeIs('committee.*') ? 'active' : '' }}">@lang('messages.committee')</a></li>
                    <li><a href="{{ route('notices.index') }}" class="{{ request()->routeIs('notices.*') ? 'active' : '' }}">@lang('messages.notices')</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">@lang('messages.gallery')</a></li>
                    <li><a href="#contact" class="contact-btn">@lang('messages.contact')</a></li>
                </ul>

                <div class="navbar-actions">
                    <div class="auth-links">
                        @guest
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}" class="register-link">Register</a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" style="color:#0EA5E9;">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:none; border:none; color:#1e293b; font-weight:500; cursor:pointer; font-size:0.9rem; padding:6px 12px;">Logout</button>
                            </form>
                        @endguest
                    </div>

                    <div class="language-switcher">
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                        <span class="divider">|</span>
                        <a href="{{ route('lang.switch', 'ne') }}" class="{{ app()->getLocale() == 'ne' ? 'active' : '' }}">नेपाली</a>
                    </div>

                    <a href="{{ route('register') }}" class="btn-primary-sm">@lang('messages.become_member')</a>
                </div>
            </div>

            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- ====== MAIN CONTENT ====== -->
    <main>
        @yield('content')
    </main>

    <!-- ====== FOOTER ====== -->
    <footer class="footer" style="background:#0f172a; color:#94a3b8; padding:60px 0 30px; margin-top:0;">
        <div class="container">
            <div class="footer-grid" style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:40px;">
                <div>
                    <!-- ✅ Footer Logo: height 80px (100% increase from 40px) -->
                    <div style="display:flex; align-items:center;">
                        <img src="{{ asset('images/logo.png') }}" alt="HEAN" style="height:80px; width:auto;">
                    </div>
                    <p style="margin-top:12px; font-size:0.95rem; line-height:1.7;">@lang('messages.footer_about')</p>
                    <div style="display:flex; gap:14px; margin-top:20px;">
                        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="color:#94a3b8; background:rgba(255,255,255,0.06); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:0.3s;"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h4 style="color:#f8fafc; font-weight:600; margin-bottom:20px;">@lang('messages.footer_quick_links')</h4>
                    <ul style="list-style:none; padding:0;">
                        <li style="margin-bottom:10px;"><a href="{{ route('home') }}" style="color:#94a3b8; text-decoration:none; transition:0.2s;">@lang('messages.home')</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('about') }}" style="color:#94a3b8; text-decoration:none; transition:0.2s;">@lang('messages.about')</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('hostels.index') }}" style="color:#94a3b8; text-decoration:none; transition:0.2s;">@lang('messages.hostels')</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('committee.index') }}" style="color:#94a3b8; text-decoration:none; transition:0.2s;">@lang('messages.committee')</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('notices.index') }}" style="color:#94a3b8; text-decoration:none; transition:0.2s;">@lang('messages.notices')</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('gallery.index') }}" style="color:#94a3b8; text-decoration:none; transition:0.2s;">@lang('messages.gallery')</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color:#f8fafc; font-weight:600; margin-bottom:20px;">@lang('messages.footer_contact')</h4>
                    <ul style="list-style:none; padding:0;">
                        <li style="margin-bottom:10px;"><i class="fas fa-map-marker-alt" style="color:#0EA5E9; width:20px;"></i> @lang('messages.footer_address')</li>
                        <li style="margin-bottom:10px;"><i class="fas fa-phone" style="color:#0EA5E9; width:20px;"></i> @lang('messages.footer_phone')</li>
                        <li style="margin-bottom:10px;"><i class="fas fa-envelope" style="color:#0EA5E9; width:20px;"></i> @lang('messages.footer_email')</li>
                        <li style="margin-bottom:10px;"><i class="fas fa-clock" style="color:#0EA5E9; width:20px;"></i> @lang('messages.footer_office_hours')</li>
                    </ul>
                </div>
                <div>
                    <h4 style="color:#f8fafc; font-weight:600; margin-bottom:20px;">Newsletter</h4>
                    <p style="font-size:0.9rem; margin-bottom:15px;">Subscribe to get updates.</p>
                    <form>
                        <input type="email" placeholder="Your email" style="width:100%; padding:10px 14px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); color:#fff; margin-bottom:10px;">
                        <button type="submit" style="background:#0EA5E9; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Subscribe</button>
                    </form>
                    <p style="margin-top:20px; font-size:0.85rem; color:#64748b;">Technology Partner: <strong style="color:#f8fafc;">HostelHub Nepal</strong></p>
                </div>
            </div>
            <div style="margin-top:40px; padding-top:20px; border-top:1px solid rgba(255,255,255,0.06); text-align:center; font-size:0.85rem;">
                <p>
                    @php $year = date('Y'); @endphp
                    @lang('messages.footer_copyright', ['year' => $year])
                    &nbsp;|&nbsp;
                    <a href="#" style="color:#94a3b8; text-decoration:none;">@lang('messages.footer_privacy')</a>
                    &nbsp;|&nbsp;
                    <a href="#" style="color:#94a3b8; text-decoration:none;">@lang('messages.footer_terms')</a>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')

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
</html>