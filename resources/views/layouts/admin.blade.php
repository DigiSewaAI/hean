<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HEAN Admin')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        .dashboard-body { cursor: default !important; }
        .sidebar .nav-item { cursor: pointer; }
        .sidebar .logout button { cursor: pointer; }
        .dashboard-body * { cursor: default; }
        .sidebar .nav-item,
        .sidebar .logout button,
        .btn,
        a,
        button,
        [role="button"] { cursor: pointer !important; }

        .admin-footer {
            text-align: center;
            padding: 1.5rem 2rem;
            color: #6a7e96;
            font-size: 0.85rem;
            border-top: 1px solid #e2e8f0;
            background: white;
            margin-top: 2rem;
            border-radius: 16px 16px 0 0;
        }
        .admin-footer a {
            color: #1e5f8e;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .admin-footer a:hover {
            color: #0EA5E9;
            text-decoration: underline;
        }
        .admin-footer .brand-line {
            margin-bottom: 4px;
            color: #0b2b4a;
            font-weight: 600;
        }
        .admin-footer .brand-line span {
            color: #6a7e96;
            font-weight: 300;
        }
        .admin-footer .tech-partner {
            font-size: 0.75rem;
            color: #9aaec5;
        }
        .admin-footer .tech-partner a {
            color: #1e5f8e;
            font-weight: 600;
        }
        .admin-footer .tech-partner a:hover {
            color: #0EA5E9;
        }
        .admin-footer .copyright {
            font-size: 0.65rem;
            color: #b0c4d8;
            margin-top: 8px;
        }

        .language-switcher {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-right: 20px;
        }
        .language-switcher a {
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .language-switcher a:hover {
            opacity: 0.7;
        }
        .language-switcher .divider {
            color: #e2e8f0;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .topbar .left-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
    </style>
</head>
<body class="dashboard-body">
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="HEAN" style="height:40px;">
        </div>
        <nav>

            <!-- ===== MAIN ===== -->
            <div class="nav-section">{{ __('messages.main') }}</div>
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> <span>{{ __('messages.dashboard') }}</span>
                </a>
            @elseif(auth()->user()->role == 'owner')
                <a href="{{ route('owner.dashboard') }}" class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> <span>{{ __('messages.dashboard') }}</span>
                </a>
            @endif

            <!-- ===== ADMIN-ONLY LINKS ===== -->
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.registrations.index') }}" class="nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>{{ __('messages.applications') }}</span>
                </a>
                <a href="{{ route('admin.inspections.index') }}" class="nav-item {{ request()->routeIs('admin.inspections.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> <span>{{ __('messages.inspections') }}</span>
                </a>
                <a href="{{ route('admin.hostels.index') }}" class="nav-item {{ request()->routeIs('admin.hostels.*') ? 'active' : '' }}">
                    <i class="fas fa-hotel"></i> <span>{{ __('messages.hostels') }}</span>
                </a>
                <a href="{{ route('admin.committee.index') }}" class="nav-item {{ request()->routeIs('admin.committee.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>{{ __('messages.committee') }}</span>
                </a>
                <a href="{{ route('admin.notices.index') }}" class="nav-item {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> <span>{{ __('messages.notices') }}</span>
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> <span>{{ __('messages.gallery') }}</span>
                </a>

                <!-- ===== FINANCE ===== -->
                <div class="nav-section">{{ __('messages.finance') }}</div>

                {{-- ✅ Invoices - Primary financial management --}}
                <a href="{{ route('admin.invoices.index') }}" class="nav-item {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> <span>{{ __('messages.invoices') }}</span>
                </a>

                {{-- ✅ Payments - View only (creation through invoice) --}}
                <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i> <span>{{ __('messages.payments') }}</span>
                </a>

                {{-- ✅ Receipts - View only (auto-generated) --}}
                <a href="{{ route('admin.receipts.index') }}" class="nav-item {{ request()->routeIs('admin.receipts.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i> <span>{{ __('messages.receipts') }}</span>
                </a>

                <!-- ===== SETTINGS ===== -->
                <div class="nav-section">{{ __('messages.settings_section') }}</div>
                <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> <span>{{ __('messages.settings') }}</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> <span>{{ __('messages.reports') }}</span>
                </a>
                <a href="{{ route('admin.certificate.index') }}" class="nav-item {{ request()->routeIs('admin.certificate.*') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i> <span>{{ __('messages.certificate') }}</span>
                </a>
                <a href="{{ route('admin.cms.index') }}" class="nav-item {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i> <span>{{ __('messages.cms') }}</span>
                </a>
                <a href="{{ route('admin.import.index') }}" class="nav-item {{ request()->routeIs('admin.import.*') ? 'active' : '' }}">
                    <i class="fas fa-upload"></i> <span>{{ __('messages.import') }}</span>
                </a>
            @endif

            <!-- ===== OWNER-ONLY LINKS ===== -->
            @if(auth()->user()->role == 'owner')
                <div class="nav-section">{{ __('messages.my_account') }}</div>
                <a href="{{ route('owner.profile') }}" class="nav-item {{ request()->routeIs('owner.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> <span>{{ __('messages.profile') }}</span>
                </a>
                <a href="{{ route('owner.registrations') }}" class="nav-item {{ request()->routeIs('owner.registrations') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>{{ __('messages.my_applications') }}</span>
                </a>
                <a href="{{ route('owner.documents') }}" class="nav-item {{ request()->routeIs('owner.documents') ? 'active' : '' }}">
                    <i class="fas fa-file-pdf"></i> <span>{{ __('messages.my_documents') }}</span>
                </a>
                <a href="{{ route('owner.payments') }}" class="nav-item {{ request()->routeIs('owner.payments') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i> <span>{{ __('messages.my_payments') }}</span>
                </a>
                <a href="{{ route('owner.invoices') }}" class="nav-item {{ request()->routeIs('owner.invoices') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i> <span>{{ __('messages.my_invoices') }}</span>
                </a>
                <a href="{{ route('owner.certificates') }}" class="nav-item {{ request()->routeIs('owner.certificates') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i> <span>{{ __('messages.my_certificates') }}</span>
                </a>
                <a href="{{ route('owner.renew') }}" class="nav-item {{ request()->routeIs('owner.renew') ? 'active' : '' }}">
                    <i class="fas fa-sync"></i> <span>{{ __('messages.renew_subscription') }}</span>
                </a>
            @endif

            <!-- ===== LOGOUT ===== -->
            <div class="logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer !important;">
                        <i class="fas fa-sign-out-alt"></i> <span>{{ __('messages.logout') }}</span>
                    </button>
                </form>
            </div>

        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="left-section">
                <div class="page-title">@yield('title')</div>
                <div class="language-switcher">
                    <a href="{{ route('lang.switch', 'en') }}" style="color:{{ session('locale') == 'en' ? '#0EA5E9' : '#64748b' }};">EN</a>
                    <span class="divider">|</span>
                    <a href="{{ route('lang.switch', 'ne') }}" style="color:{{ session('locale') == 'ne' ? '#0EA5E9' : '#64748b' }};">नेपाली</a>
                </div>
            </div>
            <div class="user-info">
                <span class="name">{{ auth()->user()->name }}</span>
                <span class="role">{{ ucfirst(auth()->user()->role) }}</span>
                <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            </div>
        </div>

        @yield('content')

        <footer class="admin-footer">
            <div class="brand-line">
                <strong style="color:#0b2b4a;">HEAN</strong>
                <span style="color:#6a7e96; font-weight:300;">·</span>
                <span style="color:#4a6a8b;">{{ __('messages.management') }}</span>
            </div>
            <div class="tech-partner">
                {{ __('messages.tech_partner') }} ·
                <a href="https://www.hostelhubnepal.com" target="_blank" rel="noopener">
                    🏨 HostelHub Nepal
                </a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} HEAN · {{ __('messages.all_rights_reserved') }}
            </div>
        </footer>

    </div>

    @stack('scripts')
</body>
</html>