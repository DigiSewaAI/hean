<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HEAN Admin')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        /* Reset cursor to default */
        .dashboard-body {
            cursor: default !important;
        }
        /* Sidebar and main content polish */
        .sidebar .nav-item {
            cursor: pointer;
        }
        .sidebar .logout button {
            cursor: pointer;
        }
        /* Ensure no custom cursor from app.js */
        .dashboard-body * {
            cursor: default;
        }
        .sidebar .nav-item,
        .sidebar .logout button,
        .btn,
        a,
        button,
        [role="button"] {
            cursor: pointer !important;
        }
    </style>
</head>
<body class="dashboard-body">
    <div class="sidebar">
        <div class="brand">
    <img src="{{ asset('images/logo.png') }}" alt="HEAN" style="height:40px;">
</div>
        <nav>
            <div class="nav-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> <span>ड्यासबोर्ड</span>
            </a>
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
    </div>

    @stack('scripts')
</body>
</html>