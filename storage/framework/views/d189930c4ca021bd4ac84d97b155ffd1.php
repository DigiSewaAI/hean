<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'HEAN Admin'); ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>

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
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="HEAN" style="height:40px;">
        </div>
        <nav>

            <!-- ===== MAIN ===== -->
            <div class="nav-section"><?php echo e(__('messages.main')); ?></div>
            <?php if(auth()->user()->role == 'admin'): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-pie"></i> <span><?php echo e(__('messages.dashboard')); ?></span>
                </a>
            <?php elseif(auth()->user()->role == 'owner'): ?>
                <a href="<?php echo e(route('owner.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-pie"></i> <span><?php echo e(__('messages.dashboard')); ?></span>
                </a>
            <?php endif; ?>

            <!-- ===== ADMIN-ONLY LINKS ===== -->
            <?php if(auth()->user()->role == 'admin'): ?>
                <a href="<?php echo e(route('admin.registrations.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.registrations.*') ? 'active' : ''); ?>">
                    <i class="fas fa-file-alt"></i> <span><?php echo e(__('messages.applications')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.inspections.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.inspections.*') ? 'active' : ''); ?>">
                    <i class="fas fa-clipboard-list"></i> <span><?php echo e(__('messages.inspections')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.hostels.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.hostels.*') ? 'active' : ''); ?>">
                    <i class="fas fa-hotel"></i> <span><?php echo e(__('messages.hostels')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.committee.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.committee.*') ? 'active' : ''); ?>">
                    <i class="fas fa-users"></i> <span><?php echo e(__('messages.committee')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.notices.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.notices.*') ? 'active' : ''); ?>">
                    <i class="fas fa-bullhorn"></i> <span><?php echo e(__('messages.notices')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.gallery.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.gallery.*') ? 'active' : ''); ?>">
                    <i class="fas fa-images"></i> <span><?php echo e(__('messages.gallery')); ?></span>
                </a>

                <!-- ===== FINANCE ===== -->
                <div class="nav-section"><?php echo e(__('messages.finance')); ?></div>

                
                <a href="<?php echo e(route('admin.invoices.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.invoices.*') ? 'active' : ''); ?>">
                    <i class="fas fa-file-invoice"></i> <span><?php echo e(__('messages.invoices')); ?></span>
                </a>

                
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>">
                    <i class="fas fa-credit-card"></i> <span><?php echo e(__('messages.payments')); ?></span>
                </a>

                
                <a href="<?php echo e(route('admin.receipts.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.receipts.*') ? 'active' : ''); ?>">
                    <i class="fas fa-receipt"></i> <span><?php echo e(__('messages.receipts')); ?></span>
                </a>

                <!-- ===== SETTINGS ===== -->
                <div class="nav-section"><?php echo e(__('messages.settings_section')); ?></div>
                <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                    <i class="fas fa-cog"></i> <span><?php echo e(__('messages.settings')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-bar"></i> <span><?php echo e(__('messages.reports')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.certificate.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.certificate.*') ? 'active' : ''); ?>">
                    <i class="fas fa-certificate"></i> <span><?php echo e(__('messages.certificate')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.cms.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.cms.*') ? 'active' : ''); ?>">
                    <i class="fas fa-edit"></i> <span><?php echo e(__('messages.cms')); ?></span>
                </a>
                <a href="<?php echo e(route('admin.import.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.import.*') ? 'active' : ''); ?>">
                    <i class="fas fa-upload"></i> <span><?php echo e(__('messages.import')); ?></span>
                </a>
            <?php endif; ?>

            <!-- ===== OWNER-ONLY LINKS ===== -->
            <?php if(auth()->user()->role == 'owner'): ?>
                <div class="nav-section"><?php echo e(__('messages.my_account')); ?></div>
                <a href="<?php echo e(route('owner.profile')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.profile') ? 'active' : ''); ?>">
                    <i class="fas fa-user"></i> <span><?php echo e(__('messages.profile')); ?></span>
                </a>
                <a href="<?php echo e(route('owner.registrations')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.registrations') ? 'active' : ''); ?>">
                    <i class="fas fa-file-alt"></i> <span><?php echo e(__('messages.my_applications')); ?></span>
                </a>
                <a href="<?php echo e(route('owner.documents')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.documents') ? 'active' : ''); ?>">
                    <i class="fas fa-file-pdf"></i> <span><?php echo e(__('messages.my_documents')); ?></span>
                </a>
                <a href="<?php echo e(route('owner.payments')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.payments') ? 'active' : ''); ?>">
                    <i class="fas fa-credit-card"></i> <span><?php echo e(__('messages.my_payments')); ?></span>
                </a>
                <a href="<?php echo e(route('owner.invoices')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.invoices') ? 'active' : ''); ?>">
                    <i class="fas fa-receipt"></i> <span><?php echo e(__('messages.my_invoices')); ?></span>
                </a>
                <a href="<?php echo e(route('owner.certificates')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.certificates') ? 'active' : ''); ?>">
                    <i class="fas fa-certificate"></i> <span><?php echo e(__('messages.my_certificates')); ?></span>
                </a>
                <a href="<?php echo e(route('owner.renew')); ?>" class="nav-item <?php echo e(request()->routeIs('owner.renew') ? 'active' : ''); ?>">
                    <i class="fas fa-sync"></i> <span><?php echo e(__('messages.renew_subscription')); ?></span>
                </a>
            <?php endif; ?>

            <!-- ===== LOGOUT ===== -->
            <div class="logout">
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer !important;">
                        <i class="fas fa-sign-out-alt"></i> <span><?php echo e(__('messages.logout')); ?></span>
                    </button>
                </form>
            </div>

        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="left-section">
                <div class="page-title"><?php echo $__env->yieldContent('title'); ?></div>
                <div class="language-switcher">
                    <a href="<?php echo e(route('lang.switch', 'en')); ?>" style="color:<?php echo e(session('locale') == 'en' ? '#0EA5E9' : '#64748b'); ?>;">EN</a>
                    <span class="divider">|</span>
                    <a href="<?php echo e(route('lang.switch', 'ne')); ?>" style="color:<?php echo e(session('locale') == 'ne' ? '#0EA5E9' : '#64748b'); ?>;">नेपाली</a>
                </div>
            </div>
            <div class="user-info">
                <span class="name"><?php echo e(auth()->user()->name); ?></span>
                <span class="role"><?php echo e(ucfirst(auth()->user()->role)); ?></span>
                <div class="avatar"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></div>
            </div>
        </div>

        <?php echo $__env->yieldContent('content'); ?>

        <footer class="admin-footer">
            <div class="brand-line">
                <strong style="color:#0b2b4a;">HEAN</strong>
                <span style="color:#6a7e96; font-weight:300;">·</span>
                <span style="color:#4a6a8b;"><?php echo e(__('messages.management')); ?></span>
            </div>
            <div class="tech-partner">
                <?php echo e(__('messages.tech_partner')); ?> ·
                <a href="https://www.hostelhubnepal.com" target="_blank" rel="noopener">
                    🏨 HostelHub Nepal
                </a>
            </div>
            <div class="copyright">
                © <?php echo e(date('Y')); ?> HEAN · <?php echo e(__('messages.all_rights_reserved')); ?>

            </div>
        </footer>

    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\hean\resources\views/layouts/admin.blade.php ENDPATH**/ ?>