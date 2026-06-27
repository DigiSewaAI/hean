<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\HostelController as AdminHostelController;
use App\Http\Controllers\Admin\CommitteeController as AdminCommitteeController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CertificateController;

use Illuminate\Support\Facades\Route;

// =============================================
// LANGUAGE SWITCHER (सार्वजनिक)
// =============================================
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ne'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// =============================================
// PUBLIC ROUTES (सबैलाई पहुँच)
// =============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/hostels', [HostelController::class, 'index'])->name('hostels.index');
Route::get('/hostels/{hostel}', [HostelController::class, 'show'])->name('hostels.show');

Route::get('/committee', [CommitteeController::class, 'index'])->name('committee.index');

Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice}', [NoticeController::class, 'show'])->name('notices.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// =============================================
// DASHBOARD REDIRECT (Login पछि यहाँ redirect हुन्छ)
// =============================================
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// =============================================
// ADMIN ROUTES (auth + admin मिडलवेयर)
// =============================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Registrations
        Route::resource('registrations', RegistrationController::class)->except(['destroy']);
        Route::post('registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
        Route::post('registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

        // Inspections
        Route::get('inspections/{registration}', [InspectionController::class, 'create'])->name('inspections.create');
        Route::post('inspections', [InspectionController::class, 'store'])->name('inspections.store');

        // Hostels
        Route::resource('hostels', AdminHostelController::class);
        Route::post('hostels/{hostel}/approve', [AdminHostelController::class, 'approve'])->name('hostels.approve');
        Route::post('hostels/{hostel}/feature', [AdminHostelController::class, 'feature'])->name('hostels.feature');
        Route::post('hostels/{hostel}/hide', [AdminHostelController::class, 'hide'])->name('hostels.hide');

        // Committee
        Route::resource('committee', AdminCommitteeController::class);

        // Notices
        Route::resource('notices', AdminNoticeController::class);

        // Gallery
        Route::resource('gallery', AdminGalleryController::class);

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        // Certificate
        Route::get('certificate', [CertificateController::class, 'index'])->name('certificate.index');
        Route::post('certificate/generate', [CertificateController::class, 'generate'])->name('certificate.generate');
    });

// =============================================
// AUTH ROUTES (Breeze)
// =============================================
require __DIR__.'/auth.php';