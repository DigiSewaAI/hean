<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicRegistrationController;

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
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\BulkHostelController;

// ✅ NEW: Payment and Receipt controllers
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReceiptController;

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
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// =============================================
// PUBLIC REGISTRATION (Single page – accessed via QR)
// =============================================
Route::get('/register-hostel', [PublicRegistrationController::class, 'create'])->name('register.hostel');
Route::post('/register-hostel', [PublicRegistrationController::class, 'store'])->name('register.hostel.store');
Route::get('/registration-success/{id}', [PublicRegistrationController::class, 'success'])->name('registration.success');

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

        // ✅ Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Registrations (Full Resource except destroy)
        Route::resource('registrations', RegistrationController::class)->except(['destroy']);

        // Approve / Reject
        Route::post('registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
        Route::post('registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

        // Duplicate Review
        Route::get('duplicate-reviews', [RegistrationController::class, 'duplicateReviews'])->name('duplicate.reviews');
        Route::post('duplicate/{registration}/review', [RegistrationController::class, 'reviewDuplicate'])->name('duplicate.review');

        // Assign Inspector
        Route::post('registrations/{registration}/assign-inspector', [RegistrationController::class, 'assignInspector'])->name('registrations.assignInspector');

        // Inspections
        Route::get('inspections', [InspectionController::class, 'index'])->name('inspections.index');
        Route::get('inspections/select', [InspectionController::class, 'select'])->name('inspections.select');
        Route::get('inspections/{registration}', [InspectionController::class, 'create'])->name('inspections.create');
        Route::post('inspections', [InspectionController::class, 'store'])->name('inspections.store');

        // Hostels
        Route::resource('hostels', AdminHostelController::class);
        Route::post('hostels/{hostel}/approve', [AdminHostelController::class, 'approve'])->name('hostels.approve');
        Route::post('hostels/{hostel}/feature', [AdminHostelController::class, 'feature'])->name('hostels.feature');
        Route::post('hostels/{hostel}/hide', [AdminHostelController::class, 'hide'])->name('hostels.hide');

        // ✅ Bulk Action – admin group भित्र, resource पछि
        Route::post('hostels/bulk-action', [AdminHostelController::class, 'bulkAction'])->name('hostels.bulk.action');

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

        // Certificate (list & generate)
        Route::get('certificate', [CertificateController::class, 'index'])->name('certificate.index');
        Route::post('certificate/generate', [CertificateController::class, 'generate'])->name('certificate.generate');
        Route::get('certificates/{id}/preview', [CertificateController::class, 'show'])->name('certificates.preview');

        // Invoice Generation
        Route::post('invoices/generate', [InvoiceController::class, 'generate'])->name('invoices.generate');

        // CMS (Homepage editable)
        Route::get('cms', [CMSController::class, 'index'])->name('cms.index');
        Route::post('cms', [CMSController::class, 'update'])->name('cms.update');

        // Import Preparation
        Route::get('import', [ImportController::class, 'index'])->name('import.index');
        Route::post('import/prepare', [ImportController::class, 'prepare'])->name('import.prepare');

        // Document download (admin)
        Route::get('documents/{document}/download', [RegistrationController::class, 'downloadDocument'])->name('documents.download');

        // Invoice download (admin)
        Route::get('invoices/{invoice}/download', [RegistrationController::class, 'downloadInvoice'])->name('invoices.download');

        // Certificate download (admin)
        Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

        // ============================================================
        // ✅ NEW: PAYMENT ROUTES
        // ============================================================
        Route::resource('payments', PaymentController::class);
        Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
        Route::post('payments/{payment}/refund', [PaymentController::class, 'refund'])->name('payments.refund');

        // ============================================================
        // ✅ NEW: RECEIPT ROUTES
        // ============================================================
        Route::get('receipts', [ReceiptController::class, 'index'])->name('receipts.index');
        Route::get('receipts/{receipt}', [ReceiptController::class, 'show'])->name('receipts.show');
        Route::post('receipts/generate/{payment}', [ReceiptController::class, 'generate'])->name('receipts.generate');
        Route::get('receipts/{receipt}/download', [ReceiptController::class, 'download'])->name('receipts.download');
    });

// =============================================
// AUTH ROUTES (Breeze)
// =============================================
require __DIR__.'/auth.php';