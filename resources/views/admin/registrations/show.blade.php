@extends('layouts.admin')

@section('title', __('messages.registration_title') . ' - ' . ($registration->hostel ? $registration->hostel->registration_number : ($registration->registration_number ?? 'N/A')) . ' - HEAN Admin')

@section('content')

{{-- ===== HEADER ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-alt" style="color:#0EA5E9;"></i>
            {{ __('messages.registration') }}
            <span style="font-weight:700; color:#0EA5E9;">
                {{ $registration->hostel ? $registration->hostel->registration_number : ($registration->registration_number ?? 'N/A') }}
            </span>
            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                {{ $registration->created_at ? $registration->created_at->format('M d, Y') : __('messages.not_available') }}
            </span>
        </h2>
    </div>
    <div>
        <a href="{{ route('admin.registrations.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_list') }}
        </a>
    </div>
</div>

{{-- ===== FLASH MESSAGES ===== --}}
@if(session('success'))
    <div style="background:#f0fdf4; border-left:4px solid #16a34a; padding:12px 18px; border-radius:8px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;"></i>
        <span style="color:#14532d;">{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left:auto; background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.2rem;">&times;</button>
    </div>
@endif
@if(session('error'))
    <div style="background:#fef2f2; border-left:4px solid #dc2626; padding:12px 18px; border-radius:8px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;"></i>
        <span style="color:#7f1d1d;">{{ session('error') }}</span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left:auto; background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.2rem;">&times;</button>
    </div>
@endif

{{-- ============================================================ --}}
{{-- SECTION 1: OVERVIEW (Status + Basic Info) --}}
{{-- ============================================================ --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px; margin-bottom:24px;">
    {{-- Left: Status & Info --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        <div style="display:flex; flex-wrap:wrap; align-items:center; gap:16px; margin-bottom:12px;">
            @php
                // Determine actual status for display
                $displayStatus = $registration->status;
                if ($registration->status === 'approved') {
                    $hasInvoice = $registration->invoices->isNotEmpty();
                    if ($hasInvoice) {
                        $latestInvoice = $registration->invoices->sortByDesc('id')->first();
                        if ($latestInvoice && $latestInvoice->status !== 'paid') {
                            $displayStatus = 'awaiting_payment';
                        }
                    }
                }
                $statusColorMap = [
                    'pending' => ['bg' => '#e2e8f0', 'text' => '#475569'],
                    'approved' => ['bg' => '#dcfce7', 'text' => '#166534'],
                    'awaiting_payment' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'active' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                    'expired' => ['bg' => '#f1f5f9', 'text' => '#64748b'],
                    'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    'duplicate' => ['bg' => '#fce4ec', 'text' => '#880e4f'],
                    'inspection' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                ];
                $colors = $statusColorMap[$displayStatus] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
            @endphp
            <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 18px; border-radius:50px; font-weight:600; font-size:0.85rem; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
                <span style="width:8px; height:8px; border-radius:50%; display:inline-block; background:{{ $colors['text'] }};"></span>
                {{ __('messages.status_' . $displayStatus) }}
            </span>
            <span style="color:#64748b; font-size:0.85rem;">
                <i class="far fa-clock"></i> {{ $registration->submitted_at ? $registration->submitted_at->diffForHumans() : __('messages.not_submitted') }}
            </span>
            <span style="color:#94a3b8;">|</span>
            <span style="color:#64748b; font-size:0.85rem;">
                <i class="fas fa-tag"></i> {{ __('messages.source') }}: <strong>{{ ucfirst($registration->source ?? 'N/A') }}</strong>
            </span>
        </div>

        {{-- Basic Info Grid --}}
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; padding-top:12px; border-top:1px solid #e2e8f0;">
                              <div>
                <span style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.hostel_name') }}</span>
                <p style="font-weight:600; color:#0f172a; margin:2px 0 0;">
                    {{ $registration->hostel_name ?? 'N/A' }}
                    @if($registration->hostel_name_english && $registration->hostel_name_english != $registration->hostel_name)
                        <br><span style="font-weight:400; color:#64748b; font-size:0.85rem;">{{ $registration->hostel_name_english }}</span>
                    @endif
                </p>
            </div>
            <div>
                <span style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.hostel_type') }}</span>
                <p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ ucfirst($registration->hostel_type ?? 'N/A') }}</p>
            </div>
            <div>
                <span style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.district') }}</span>
                <p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->district ?? 'N/A' }}</p>
            </div>
        </div>
                {{-- Local Registration Number --}}
<div style="grid-column:1/-1; background:#f0f9ff; padding:10px 14px; border-radius:8px; border-left:4px solid #0EA5E9;">
    <label style="font-size:0.7rem; text-transform:uppercase; color:#0EA5E9; font-weight:700;">
        {{ __('messages.local_registration_number') }}
    </label>
    <p style="font-weight:700; color:#0f172a; margin:2px 0 0; font-size:1.1rem;">
        {{ $registration->local_registration_number ?? __('messages.not_available') }}
    </p>
</div>
{{-- ✅ पुरानो दर्ता नम्बर (Excel S.N.) --}}
@if($registration->old_registration_number)
    <div style="grid-column:1/-1; background:#f0f9ff; padding:10px 14px; border-radius:8px; border-left:4px solid #0EA5E9; margin-top:8px;">
        <label style="font-size:0.7rem; text-transform:uppercase; color:#0EA5E9; font-weight:700;">
            पुरानो दर्ता नम्बर
        </label>
        <p style="font-weight:700; color:#0f172a; margin:2px 0 0; font-size:1.1rem;">
            {{ $registration->old_registration_number }}
        </p>
    </div>
@endif
    </div>

    

    {{-- Right: Workflow Status (Highlighted Steps) --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        <div style="font-weight:600; color:#0f172a; font-size:0.85rem; margin-bottom:8px;">{{ __('messages.workflow_status') }}</div>
        @php
            $hasInvoice = $registration->invoices->isNotEmpty();
            $hasPayment = $registration->payments->isNotEmpty();
            $paymentVerified = $hasPayment && $registration->payments->where('status', 'verified')->isNotEmpty();
            $hasReceipt = $registration->receipts->isNotEmpty();
            $isActive = $registration->status === 'active';
            $isAwaitingPayment = $displayStatus === 'awaiting_payment';
            $steps = [
                '📋 Registration' => true,
                '📄 Invoice' => $hasInvoice,
                '💳 Payment' => $hasPayment,
                '🧾 Receipt' => $hasReceipt,
                '✅ Active' => $isActive,
            ];
            // Determine which step is current (active)
            $activeStep = 'Registration';
            if ($isActive) $activeStep = 'Active';
            elseif ($hasReceipt) $activeStep = 'Receipt';
            elseif ($paymentVerified) $activeStep = 'Payment'; // or 'Verified'
            elseif ($hasPayment) $activeStep = 'Payment';
            elseif ($hasInvoice) $activeStep = 'Invoice';
        @endphp
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            @foreach($steps as $label => $completed)
                @php
                    $isActiveStep = ($label == $activeStep);
                @endphp
                <span style="padding:4px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                    {{ $completed ? ($isActiveStep ? 'background:#3b82f6; color:#fff;' : 'background:#dcfce7; color:#166534;') : 'background:#f1f5f9; color:#94a3b8;' }}
                    {{ $isActiveStep ? 'border:2px solid #1e3a8a;' : '' }}
                ">
                    {{ $label }}
                </span>
                @if(!$loop->last) <span style="color:#cbd5e1;">→</span> @endif
            @endforeach
        </div>
        <div style="margin-top:8px; font-size:0.8rem; color:#64748b;">
            @if($isActive)
                ✅ {{ __('messages.registration_active') }}
            @elseif($isAwaitingPayment)
                ⏳ {{ __('messages.awaiting_payment') }}
            @elseif($hasInvoice && !$paymentVerified)
                💰 {{ __('messages.payment_pending') }}
            @elseif($displayStatus === 'pending')
                📝 {{ __('messages.awaiting_approval') }}
            @else
                {{ __('messages.status_' . $displayStatus) }}
            @endif
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- SECTION 2: FINANCIAL SUMMARY --}}
{{-- ============================================================ --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:12px;">
        <h4 style="margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-chart-pie" style="color:#0EA5E9;"></i> {{ __('messages.financial_summary') }}
        </h4>
        @if($registration->invoices->isNotEmpty())
            <a href="{{ route('admin.invoices.show', $registration->invoices->sortByDesc('id')->first()) }}" 
               style="display:inline-flex; align-items:center; gap:6px; background:#0EA5E9; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem; font-weight:500;">
                <i class="fas fa-arrow-right"></i> {{ __('messages.view_finance') }}
            </a>
        @endif
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px;">
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.invoices') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">{{ $registration->invoices?->count() ?? 0 }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.total_invoiced') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">NPR {{ number_format($totalInvoiced ?? 0, 2) }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.total_paid') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#22C55E;">NPR {{ number_format($totalPaid ?? 0, 2) }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.outstanding') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#EF4444;">NPR {{ number_format($outstanding ?? 0, 2) }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.latest_receipt') }}</div>
            @if($latestReceipt)
                <a href="{{ route('admin.receipts.download', $latestReceipt) }}" style="font-weight:700; color:#0EA5E9; text-decoration:none; font-size:0.9rem;">
                    {{ $latestReceipt->receipt_number }}
                </a>
            @else
                <span style="color:#94a3b8;">{{ __('messages.none') }}</span>
            @endif
        </div>
    </div>

    {{-- Next Action --}}
    @php
        $nextAction = '';
        $nextActionLink = null;
        if ($registration->status === 'pending') {
            $nextAction = 'Approve this registration';
            // No link, admin can click approve button
        } elseif ($displayStatus === 'approved' && !$hasInvoice) {
            $nextAction = 'Generate an invoice';
            $nextActionLink = '#invoiceForm';
        } elseif ($displayStatus === 'awaiting_payment' && $hasInvoice) {
            $invoice = $registration->invoices->sortByDesc('id')->first();
            if ($invoice && $invoice->status !== 'paid') {
                $nextAction = 'Add payment for invoice ' . $invoice->invoice_number;
                $nextActionLink = route('admin.payments.create', ['invoice_id' => $invoice->id]);
            } else {
                $nextAction = 'Verify the pending payment';
                // Find pending payment
                $pendingPayment = $registration->payments->where('status', 'pending')->first();
                if ($pendingPayment) {
                    $nextActionLink = route('admin.payments.show', $pendingPayment);
                }
            }
        } elseif ($registration->status === 'active') {
            $nextAction = 'Registration is active. Valid until ' . ($registration->valid_until ? $registration->valid_until->format('Y-m-d') : 'N/A');
        } else {
            $nextAction = 'No action required';
        }
    @endphp
    <div style="margin-top:12px; padding-top:12px; border-top:1px solid #e2e8f0;">
        <div style="display:flex; align-items:center; gap:8px; font-size:0.9rem;">
            <span style="font-weight:600; color:#0f172a;">{{ __('messages.next_action') }}:</span>
            @if($nextActionLink)
                <a href="{{ $nextActionLink }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                    {{ $nextAction }}
                </a>
            @else
                <span style="color:#64748b;">{{ $nextAction }}</span>
            @endif
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- SECTION 3: INVOICES (with Download/Generate buttons) --}}
{{-- ============================================================ --}}
@php
    $latestInvoice = $registration->invoices->sortByDesc('id')->first();
    $hasInvoice = $registration->invoices->isNotEmpty();
    $canGenerateInvoice = !$hasInvoice || ($hasInvoice && $latestInvoice && $latestInvoice->status === 'paid');
@endphp

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-file-invoice"></i> {{ __('messages.invoices') }}
        <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">({{ $registration->invoices?->count() ?? 0 }})</span>
        @if($canGenerateInvoice)
            <button type="button" onclick="document.getElementById('invoiceForm').style.display='block'" 
                style="margin-left:auto; background:rgba(255,255,255,0.2); color:#fff; border:1px solid rgba(255,255,255,0.3); padding:4px 16px; border-radius:50px; font-weight:600; font-size:0.75rem; cursor:pointer;">
                <i class="fas fa-file-invoice"></i> {{ __('messages.generate_invoice') }}
            </button>
        @endif
    </div>
    <div style="padding:16px;">
        @if($hasInvoice)
            @foreach($registration->invoices as $invoice)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <div>
                    <a href="{{ route('admin.invoices.show', $invoice) }}" style="font-weight:600; color:#0EA5E9; text-decoration:none;">
                        {{ $invoice->invoice_number }}
                    </a>
                    <span style="font-size:0.75rem; color:#94a3b8; margin-left:8px;">{{ __('messages.type') }}: {{ __('messages.invoice_type_'.$invoice->invoice_type) }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="font-weight:700;">NPR {{ number_format($invoice->amount, 2) }}</span>
                    <span style="font-size:0.7rem; padding:2px 10px; border-radius:50px; font-weight:600; 
                        @if($invoice->status == 'paid') background:#dcfce7; color:#166534;
                        @elseif($invoice->status == 'partial') background:#fef3c7; color:#92400e;
                        @elseif($invoice->status == 'overdue') background:#fee2e2; color:#991b1b;
                        @else background:#e2e8f0; color:#475569; @endif">
                        {{ __('messages.status_'.$invoice->status) }}
                    </span>
                    <div style="display:flex; gap:4px;">
                        <a href="{{ route('admin.invoices.show', $invoice) }}" style="background:#0EA5E9; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($invoice->pdf_path)
                            <a href="{{ route('admin.invoices.download', $invoice) }}" style="background:#22C55E; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                                <i class="fas fa-download"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align:center; padding:20px; color:#94a3b8;">{{ __('messages.no_invoices') }}</div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- SECTION 4: PAYMENTS (with Add Payment button inside) --}}
{{-- ============================================================ --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-credit-card"></i> {{ __('messages.payments') }}
        <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">({{ $registration->payments?->count() ?? 0 }})</span>
        @if($hasInvoice && $latestInvoice && $latestInvoice->status !== 'paid')
            <a href="{{ url('/admin/payments/create?invoice_id=' . $latestInvoice->id) }}" 
   style="display:inline-flex; align-items:center; gap:6px; background:#F59E0B; color:#fff; padding:8px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem;">
    <i class="fas fa-plus-circle"></i> {{ __('messages.add_payment') }}
</a>
        @endif
    </div>
    <div style="padding:16px;">
        @if($registration->payments?->count())
            @foreach($registration->payments as $payment)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <div>
                    <span style="font-weight:500;">{{ ucfirst($payment->method) }}</span>
                    <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;">{{ $payment->transaction_id ?? 'N/A' }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="font-weight:600;">NPR {{ number_format($payment->amount, 2) }}</span>
                    <span style="font-size:0.65rem; padding:2px 10px; border-radius:50px; font-weight:600; 
                        @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                        @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                        @else background:#fee2e2; color:#991b1b; @endif
                    ">
                        {{ __('messages.status_'.$payment->status) }}
                    </span>
                    <a href="{{ route('admin.payments.show', $payment) }}" style="background:#0EA5E9; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align:center; padding:12px; color:#94a3b8; font-size:0.85rem;">{{ __('messages.no_payments_recorded') }}</div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- SECTION 5: RECEIPTS (with View/Download buttons) --}}
{{-- ============================================================ --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-receipt"></i> {{ __('messages.receipts') }}
        <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">({{ $registration->receipts?->count() ?? 0 }})</span>
    </div>
    <div style="padding:16px;">
        @if($registration->receipts?->count())
            @foreach($registration->receipts as $receipt)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <div>
                    <span style="font-weight:500;">{{ $receipt->receipt_number }}</span>
                    <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;">{{ $receipt->issued_date->format('Y-m-d') }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="font-weight:600;">NPR {{ number_format($receipt->amount, 2) }}</span>
                    <a href="{{ route('admin.receipts.show', $receipt) }}" style="background:#0EA5E9; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.receipts.download', $receipt) }}" style="background:#22C55E; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align:center; padding:12px; color:#94a3b8; font-size:0.85rem;">{{ __('messages.no_receipts') }}</div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- SECTION 6: DOCUMENTS, INSPECTIONS, DUPLICATE REVIEWS --}}
{{-- ============================================================ --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">

    {{-- ============================================================ --}}
{{-- ============================================================ --}}
{{-- DOCUMENTS (UPGRADED - No Gallery) --}}
{{-- ============================================================ --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #64748B, #475569); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-file-pdf"></i> {{ __('messages.documents') }}
        <span style="font-size:0.8rem; font-weight:400; opacity:0.8; margin-left:auto;">
            {{ $registration->uploadedDocuments->count() }} {{ __('messages.files') }}
        </span>
    </div>
    <div style="padding:16px;">
        @php
    // === Public type लाई Admin type मा म्याप गर्ने ===
    $typeMapping = [
        'pan_certificate' => 'pan',
        'citizenship_copy' => 'citizenship',
        'registration_certificate' => 'license',
        'other_documents' => 'additional',
        'additional_documents' => 'additional',
        // यदि अरू public type छ भने यहाँ थप्नुहोस्
    ];

    // === सबै डकुमेन्टलाई म्याप गरेर समूहबद्ध गर्ने ===
    $groupedDocs = [];
    foreach ($registration->uploadedDocuments as $doc) {
        $groupKey = $typeMapping[$doc->type] ?? $doc->type; // यदि mapping छैन भने आफ्नै type
        $groupedDocs[$groupKey][] = $doc;
    }

    // === अब एउटा मात्र group definition (Admin type अनुसार) ===
    $docGroups = [
        'pan' => ['label' => 'PAN Certificate', 'icon' => 'fa-file-invoice'],
        'citizenship' => ['label' => __('messages.citizenship_copy'), 'icon' => 'fa-id-card'],
        'license' => ['label' => 'Business Registration Certificate', 'icon' => 'fa-building'],
        'municipality' => ['label' => 'Municipality Certificate', 'icon' => 'fa-certificate'],
        'signboard' => ['label' => __('messages.signboard_building_image'), 'icon' => 'fa-image'],
        'photos' => ['label' => 'होस्टल तस्बिरहरू', 'icon' => 'fa-images'],
        'additional' => ['label' => 'Additional Documents', 'icon' => 'fa-paperclip'],
    ];
@endphp

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:16px;">
    @foreach($docGroups as $type => $info)
        @php
            $docs = $groupedDocs[$type] ?? collect(); // म्याप गरिएको समूहबाट लिने
        @endphp

        @if($type === 'photos')
            @foreach($docs as $doc)
                @php $singleDoc = collect([$doc]); @endphp
                @include('admin.registrations.partials._document_card', [
                    'type' => 'photo_single',
                    'docs' => $singleDoc,
                    'label' => 'Photo ' . ($loop->iteration),
                    'icon' => 'fa-image'
                ])
            @endforeach
        @else
            @include('admin.registrations.partials._document_card', [
                'type' => $type,
                'docs' => $docs,
                'label' => $info['label'],
                'icon' => $info['icon']
            ])
        @endif
    @endforeach
</div>

        {{-- If no documents at all --}}
        @if($registration->uploadedDocuments->isEmpty())
            <div style="text-align:center; padding:20px; color:#94a3b8; font-size:0.85rem;">
                <i class="fas fa-file-alt" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                {{ __('messages.no_documents_uploaded') }}
            </div>
        @endif
    </div>
</div>
    {{-- Inspections --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-clipboard-check"></i> {{ __('messages.inspections') }}
            <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">({{ $registration->inspections?->count() ?? 0 }})</span>
        </div>
        <div style="padding:16px;">
            @if($registration->inspections?->count())
                @foreach($registration->inspections as $inspection)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #e2e8f0;">
                        <div>
                            <span style="font-weight:500;">{{ $inspection->scheduled_date }}</span>
                            <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;">{{ $inspection->remarks ?? __('messages.no_remarks') }}</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                                @if($inspection->status == 'completed') background:#dcfce7; color:#166534;
                                @else background:#fef3c7; color:#92400e; @endif">
                                {{ __('messages.status_' . $inspection->status) }}
                            </span>
                            @if($inspection->status == 'completed')
                                <a href="#" style="background:#8B5CF6; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.65rem; font-weight:600;">
                                    <i class="fas fa-eye"></i> {{ __('messages.view') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:20px; color:#94a3b8; font-size:0.85rem;">{{ __('messages.no_inspections_scheduled') }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Duplicate Reviews --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #EF4444, #DC2626); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-copy"></i> {{ __('messages.duplicate_reviews') }}
    </div>
    <div style="padding:16px;">
        @php
            $hasReview = $registration->duplicateReviews?->isNotEmpty();
        @endphp
        @if($hasReview)
            @foreach($registration->duplicateReviews as $review)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #e2e8f0;">
                    <div>
                        <span style="font-weight:500;">{{ $review->reviewedBy->name ?? __('messages.not_available') }}</span>
                        <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;">{{ $review->notes ?? __('messages.no_notes') }}</span>
                    </div>
                    <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                        @if($review->is_duplicate) background:#fee2e2; color:#991b1b;
                        @else background:#dcfce7; color:#166534; @endif">
                        {{ $review->is_duplicate ? __('messages.yes') : __('messages.no') }}
                    </span>
                </div>
            @endforeach
        @else
            <div style="text-align:center; padding:12px; color:#94a3b8; font-size:0.85rem;">{{ __('messages.no_duplicate_reviews') }}</div>
        @endif

        <div style="margin-top:12px; display:flex; gap:8px;">
            @if(!$hasReview)
                <form action="{{ route('admin.duplicate.review', $registration) }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_duplicate" value="0">
                    <button type="submit" style="background:#22C55E; color:#fff; border:none; padding:4px 16px; border-radius:50px; font-weight:600; font-size:0.75rem; cursor:pointer;">
                        <i class="fas fa-check"></i> {{ __('messages.not_duplicate') }}
                    </button>
                </form>
                <form action="{{ route('admin.duplicate.review', $registration) }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_duplicate" value="1">
                    <button type="submit" style="background:#EF4444; color:#fff; border:none; padding:4px 16px; border-radius:50px; font-weight:600; font-size:0.75rem; cursor:pointer;">
                        <i class="fas fa-exclamation-triangle"></i> {{ __('messages.mark_as_duplicate') }}
                    </button>
                </form>
            @else
                <span style="color:#94a3b8; font-size:0.8rem;">{{ __('messages.review_completed') }}</span>
            @endif
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- SECTION 7: ACTIONS (Grouped) --}}
{{-- ============================================================ --}}
<div style="margin-top:24px;">
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #1E293B, #0F172A); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-tools"></i> {{ __('messages.actions') }}
        </div>
        <div style="padding:16px; display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px;">

            {{-- Financial Actions --}}
            <div>
                <h5 style="margin:0 0 8px 0; font-size:0.85rem; color:#0EA5E9;">{{ __('messages.finance') }}</h5>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    @if($hasInvoice && $latestInvoice)
                        <a href="{{ route('admin.invoices.show', $latestInvoice) }}" style="display:inline-flex; align-items:center; gap:4px; background:#0EA5E9; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                            <i class="fas fa-eye"></i> {{ __('messages.view_invoice') }}
                        </a>
                        @if($latestInvoice->status !== 'paid')
                            <a href="{{ route('admin.payments.create', ['invoice_id' => $latestInvoice->id]) }}" style="display:inline-flex; align-items:center; gap:4px; background:#F59E0B; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                                <i class="fas fa-plus"></i> {{ __('messages.add_payment') }}
                            </a>
                        @endif
                    @elseif($canGenerateInvoice)
                        <button type="button" onclick="document.getElementById('invoiceForm').style.display='block'" style="display:inline-flex; align-items:center; gap:4px; background:#8B5CF6; color:#fff; border:none; padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; cursor:pointer;">
                            <i class="fas fa-file-invoice"></i> {{ __('messages.generate_invoice') }}
                        </button>
                    @endif
                </div>
            </div>

            {{-- Inspection Actions --}}
            <div>
                <h5 style="margin:0 0 8px 0; font-size:0.85rem; color:#06B6D4;">{{ __('messages.inspection') }}</h5>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    @php
                        $hasCompletedInspection = $registration->inspections->where('status', 'completed')->isNotEmpty();
                    @endphp
                    @if($hasCompletedInspection)
                        @php
                            $completedInspection = $registration->inspections->where('status', 'completed')->first();
                        @endphp
                        @if($completedInspection)
                            <a href="{{ route('admin.inspections.view', $completedInspection) }}" style="display:inline-flex; align-items:center; gap:4px; background:#8B5CF6; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                                <i class="fas fa-eye"></i> {{ __('messages.view_inspection') }}
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Management Actions --}}
            <div>
                <h5 style="margin:0 0 8px 0; font-size:0.85rem; color:#64748B;">{{ __('messages.management') }}</h5>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    @if($registration->status === 'pending')
                        <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="display:inline-flex; align-items:center; gap:4px; background:#22C55E; color:#fff; border:none; padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; cursor:pointer;">
                                <i class="fas fa-check"></i> {{ __('messages.approve') }}
                            </button>
                        </form>
                        <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="display:inline-flex; align-items:center; gap:4px; background:#EF4444; color:#fff; border:none; padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; cursor:pointer;">
                                <i class="fas fa-times"></i> {{ __('messages.reject') }}
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.registrations.edit', $registration) }}" style="display:inline-flex; align-items:center; gap:4px; background:#F59E0B; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                        <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                    </a>
                </div>
            </div>

        </div>

        {{-- Inspector Form (Hidden) --}}
        <div id="inspectorForm" style="display:none; background:#f8fafc; border-radius:12px; padding:16px; margin:0 16px 16px 16px;">
            <form action="{{ route('admin.registrations.assignInspector', $registration) }}" method="POST">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;">{{ __('messages.inspector') }} <span style="color:#dc2626;">*</span></label>
                        <select name="inspector_id" required style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#fff;">
                            <option value="">{{ __('messages.select_inspector') }}</option>
                            @forelse($inspectors ?? [] as $inspector)
                                <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                            @empty
                                <option value="" disabled>{{ __('messages.no_inspectors_available') }}</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;">{{ __('messages.scheduled_date') }} <span style="color:#dc2626;">*</span></label>
                        <input type="date" name="scheduled_date" required style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;">{{ __('messages.remarks_optional') }}</label>
                        <input type="text" name="remarks" placeholder="{{ __('messages.remarks_placeholder_schedule') }}" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                </div>
                <div style="margin-top:12px; text-align:right;">
                    <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.8rem; cursor:pointer; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                        <i class="fas fa-calendar-plus"></i> {{ __('messages.assign_and_schedule') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Invoice Form (Hidden) --}}
        @if($canGenerateInvoice)
        <div id="invoiceForm" style="display:none; background:#f8fafc; border-radius:12px; padding:16px; margin:0 16px 16px 16px;">
            <form action="{{ route('admin.invoices.generate') }}" method="POST">
                @csrf
                <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;">{{ __('messages.invoice_type') }} <span style="color:#dc2626;">*</span></label>
                        <select name="invoice_type" required style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#fff;">
    <option value="new_registration">{{ __('messages.invoice_type_new_registration') }}</option>
    <option value="renewal">{{ __('messages.invoice_type_renewal') }}</option>
    {{-- <option value="membership_fee">{{ __('messages.invoice_type_membership_fee') }}</option> --}} {{-- यो हटाइयो --}}
    <option value="inspection_fee">{{ __('messages.invoice_type_inspection_fee') }}</option>
    <option value="certificate_fee">{{ __('messages.invoice_type_certificate_fee') }}</option>
    <option value="penalty">{{ __('messages.invoice_type_penalty') }}</option>
    {{-- नयाँ ४ वटा थपियो --}}
    <option value="log_book">{{ __('messages.invoice_type_log_book') }}</option>
    <option value="leave_form">{{ __('messages.invoice_type_leave_form') }}</option>
    <option value="student_admission_form">{{ __('messages.invoice_type_student_admission_form') }}</option>
    <option value="code_of_conduct_board">{{ __('messages.invoice_type_code_of_conduct_board') }}</option>
    <option value="other">{{ __('messages.invoice_type_other') }}</option>
</select>
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;">{{ __('messages.amount_npr') }} <span style="color:#dc2626;">*</span></label>
                        <input type="number" name="amount" step="0.01" required placeholder="0.00" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;">{{ __('messages.due_date') }}</label>
                        <input type="date" name="due_date" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                </div>
                <div style="margin-top:12px; text-align:right;">
                    <button type="submit" style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; border:none; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.8rem; cursor:pointer; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                        <i class="fas fa-file-invoice"></i> {{ __('messages.generate_invoice') }}
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</div>
{{-- ===== MODALS ===== --}}
@include('admin.registrations.partials._document_modal')

@push('scripts')
    <script src="{{ asset('js/admin-document-manager.js') }}"></script>
@endpush
@endsection