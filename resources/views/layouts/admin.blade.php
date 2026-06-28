<!DOCTYPE html>
<html lang="ne">
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

        /* Footer styling */
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
    </style>
</head>
<body class="dashboard-body">
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="HEAN" style="height:40px;">
        </div>
        <nav>

            <!-- ===== COMMON DASHBOARD LINK ===== -->
            <div class="nav-section">Main</div>
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> <span>ड्यासबोर्ड</span>
                </a>
            @elseif(auth()->user()->role == 'owner')
                <a href="{{ route('owner.dashboard') }}" class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> <span>ड्यासबोर्ड</span>
                </a>
            @endif

            <!-- ===== ADMIN-ONLY LINKS ===== -->
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.registrations.index') }}" class="nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>आवेदनहरू</span>
                </a>
                <a href="{{ route('admin.hostels.index') }}" class="nav-item {{ request()->routeIs('admin.hostels.*') ? 'active' : '' }}">
                    <i class="fas fa-hotel"></i> <span>होस्टेलहरू</span>
                </a>
                <a href="{{ route('admin.committee.index') }}" class="nav-item {{ request()->routeIs('admin.committee.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>समिति</span>
                </a>
                <a href="{{ route('admin.notices.index') }}" class="nav-item {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> <span>सूचनाहरू</span>
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> <span>ग्यालरी</span>
                </a>
                <div class="nav-section">Settings</div>
                <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> <span>सेटिङ</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> <span>रिपोर्ट</span>
                </a>
                <a href="{{ route('admin.certificate.index') }}" class="nav-item {{ request()->routeIs('admin.certificate.*') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i> <span>प्रमाणपत्र</span>
                </a>
                <a href="{{ route('admin.cms.index') }}" class="nav-item {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i> <span>CMS</span>
                </a>
                <a href="{{ route('admin.import.index') }}" class="nav-item {{ request()->routeIs('admin.import.*') ? 'active' : '' }}">
                    <i class="fas fa-upload"></i> <span>Import</span>
                </a>
            @endif

            <!-- ===== OWNER-ONLY LINKS ===== -->
            @if(auth()->user()->role == 'owner')
                <div class="nav-section">My Account</div>
                <a href="{{ route('owner.profile') }}" class="nav-item {{ request()->routeIs('owner.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> <span>प्रोफाइल</span>
                </a>
                <a href="{{ route('owner.registrations') }}" class="nav-item {{ request()->routeIs('owner.registrations') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>मेरा आवेदनहरू</span>
                </a>
                <a href="{{ route('owner.documents') }}" class="nav-item {{ request()->routeIs('owner.documents') ? 'active' : '' }}">
                    <i class="fas fa-file-pdf"></i> <span>मेरा कागजात</span>
                </a>
                <a href="{{ route('owner.payments') }}" class="nav-item {{ request()->routeIs('owner.payments') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i> <span>मेरा भुक्तानी</span>
                </a>
                <a href="{{ route('owner.invoices') }}" class="nav-item {{ request()->routeIs('owner.invoices') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i> <span>मेरा इनभ्वाइस</span>
                </a>
                <a href="{{ route('owner.certificates') }}" class="nav-item {{ request()->routeIs('owner.certificates') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i> <span>मेरा प्रमाणपत्र</span>
                </a>
                <a href="{{ route('owner.renew') }}" class="nav-item {{ request()->routeIs('owner.renew') ? 'active' : '' }}">
                    <i class="fas fa-sync"></i> <span>सदस्यता नवीकरण</span>
                </a>
            @endif

            <!-- ===== LOGOUT (सबैको लागि) ===== -->
            <div class="logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer !important;">
                        <i class="fas fa-sign-out-alt"></i> <span>लगआउट</span>
                    </button>
                </form>
            </div>

        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="page-title">@yield('title')</div>
            <div class="user-info">
                <span class="name">{{ auth()->user()->name }}</span>
                <span class="role">{{ ucfirst(auth()->user()->role) }}</span>
                <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            </div>
        </div>

        <!-- ✅ MAIN CONTENT -->
        @yield('content')

        <!-- ✅ ADMIN FOOTER (अपडेटेड – HostelHub हटाइयो) -->
        <footer class="admin-footer">
            <div class="brand-line">
                <strong style="color:#0b2b4a;">HEAN</strong>
                <span style="color:#6a7e96; font-weight:300;">·</span>
                <span style="color:#4a6a8b;">व्यवस्थापन</span>
            </div>
            <div class="tech-partner">
                प्राविधिक साझेदार (Technology Partner) ·
                <a href="https://www.hostelhubnepal.com" target="_blank" rel="noopener">
                    🏨 HostelHub Nepal
                </a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} HEAN · सबै अधिकार सुरक्षित
            </div>
        </footer>

    </div> <!-- /.main-content -->

    @stack('scripts')
</body>
</html>