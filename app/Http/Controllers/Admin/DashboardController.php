<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Hostel;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ========================================================
        // 1. PRIMARY STATS
        // ========================================================
        $totalHostels = Hostel::count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();
        $inspectionsPending = Registration::where('status', 'active')
    ->whereDoesntHave('inspections')
    ->count();

        $members = User::where('role', '!=', 'viewer')->count();

        // ========================================================
        // 2. SECONDARY STATS
        // ========================================================
        $activeHostels = Hostel::where('approved', true)->where('visible', true)->count();
        $totalRevenue = Payment::where('status', 'verified')->sum('amount') ?? 0;
        $totalCertificates = Certificate::count();
        $totalInvoices = Invoice::count();

        $todayRegistrations = Registration::whereDate('created_at', Carbon::today())->count();
        $thisWeekRegistrations = Registration::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $thisMonthRegistrations = Registration::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $expiredRegistrations = Registration::where('status', 'active')
            ->where('valid_until', '<', Carbon::today())
            ->count();

        // ========================================================
        // 3. CHARTS DATA (FIXED - Direct DB queries with fallbacks)
        // ========================================================

        // 3.1 Monthly Registrations (Last 12 Months) - FIXED
        $monthlyRegistrations = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Registration::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyRegistrations->push([
                'label' => $date->format('M Y'),
                'count' => $count,
            ]);
        }

        // 3.2 Hostel Type Distribution - FIXED (handle NULL values)
        $typeDistribution = Hostel::select('type', DB::raw('count(*) as total'))
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->groupBy('type')
            ->pluck('total', 'type');
        
        // If empty, add default with zero values to show chart
        if ($typeDistribution->isEmpty()) {
            $typeDistribution = collect(['boys' => 0, 'girls' => 0, 'co-ed' => 0]);
        }

        // 3.3 Registration Status Distribution - FIXED
        $statusDistribution = Registration::select('status', DB::raw('count(*) as total'))
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->groupBy('status')
            ->pluck('total', 'status');
        
        // If empty, add default statuses with zero
        if ($statusDistribution->isEmpty()) {
            $statusDistribution = collect([
                'pending' => 0,
                'approved' => 0,
                'active' => 0,
                'rejected' => 0,
                'duplicate' => 0,
                'awaiting_payment' => 0,
                'inspection' => 0,
            ]);
        }

        // 3.4 Monthly Revenue (Last 6 Months) - FIXED
        $monthlyRevenue = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $total = Payment::where('status', 'verified')
                ->whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->sum('amount') ?? 0;
            $monthlyRevenue->push([
                'label' => $date->format('M Y'),
                'total' => (float) $total,
            ]);
        }

        // ========================================================
        // 4. RECENT ACTIVITIES
        // ========================================================
        $recentRegistrations = Registration::with('hostel')
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with('registration')
            ->where('status', 'verified')
            ->latest()
            ->take(5)
            ->get();

        $recentCertificates = Certificate::with('registration')
            ->latest()
            ->take(5)
            ->get();

        // ========================================================
        // 5. ALERTS
        // ========================================================
        $alerts = [];

        if ($pendingRegistrations > 5) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => '⚠️',
                'message' => "{$pendingRegistrations} वटा दर्ताहरू स्वीकृतिको पर्खाइमा छन्।",
                'link' => route('admin.registrations.index', ['status' => 'pending'])
            ];
        }

        if ($expiredRegistrations > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => '🚨',
                'message' => "{$expiredRegistrations} वटा होस्टेलको दर्ता म्याद सकिएको छ।",
                'link' => route('admin.registrations.index', ['status' => 'expired'])
            ];
        }


        $overdueInvoices = Invoice::where('status', 'overdue')->count();
        if ($overdueInvoices > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => '💰',
                'message' => "{$overdueInvoices} वटा इनभ्वाइसहरूको भुक्तानी म्याद गुज्रिएको छ।",
                'link' => route('admin.invoices.index', ['status' => 'overdue'])
            ];
        }

        return view('admin.dashboard', compact(
            'totalHostels',
            'pendingRegistrations',
            'inspectionsPending',
            'members',
            'activeHostels',
            'totalRevenue',
            'totalCertificates',
            'totalInvoices',
            'todayRegistrations',
            'thisWeekRegistrations',
            'thisMonthRegistrations',
            'expiredRegistrations',
            'monthlyRegistrations',
            'typeDistribution',
            'statusDistribution',
            'monthlyRevenue',
            'recentRegistrations',
            'recentPayments',
            'recentCertificates',
            'alerts'
        ));
    }
}