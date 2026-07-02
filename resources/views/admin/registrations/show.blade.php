@extends('layouts.admin')

@section('title', __('messages.registration_title') . ' #' . $registration->id . ' - HEAN Admin')

@section('content')

{{-- ===== HEADER ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-alt" style="color:#0EA5E9;"></i>
            {{ __('messages.registration') }} #{{ $registration->id }}
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

{{-- ===== STATUS BAR (अपडेटेड – नयाँ statuses थपियो) ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; box-shadow:0 1px 3px rgba(0,0,0,0.04); margin-bottom:24px; display:flex; flex-wrap:wrap; align-items:center; gap:16px; border:1px solid #e2e8f0;">
    @php
        $statusColorMap = [
            'pending'          => ['bg' => '#e2e8f0', 'text' => '#475569', 'dot' => '#94a3b8'],
            'approved'         => ['bg' => '#dcfce7', 'text' => '#166534', 'dot' => '#22c55e'],
            'awaiting_payment' => ['bg' => '#fef3c7', 'text' => '#92400e', 'dot' => '#f59e0b'],
            'active'           => ['bg' => '#dbeafe', 'text' => '#1e40af', 'dot' => '#3b82f6'],
            'expired'          => ['bg' => '#f1f5f9', 'text' => '#64748b', 'dot' => '#94a3b8'],
            'rejected'         => ['bg' => '#fee2e2', 'text' => '#991b1b', 'dot' => '#ef4444'],
            'duplicate'        => ['bg' => '#fce4ec', 'text' => '#880e4f', 'dot' => '#e91e63'],
            'inspection'       => ['bg' => '#fef3c7', 'text' => '#92400e', 'dot' => '#f59e0b'],
        ];
        $status = $registration->status;
        $colors = $statusColorMap[$status] ?? ['bg' => '#e2e8f0', 'text' => '#475569', 'dot' => '#94a3b8'];
    @endphp
    <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 18px; border-radius:50px; font-weight:600; font-size:0.85rem; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
        <span style="width:8px; height:8px; border-radius:50%; display:inline-block; background:{{ $colors['dot'] }};"></span>
        {{ __('messages.status_' . $status) }}
    </span>
    <span style="color:#64748b; font-size:0.85rem;">
        <i class="far fa-clock"></i> {{ $registration->submitted_at ? $registration->submitted_at->diffForHumans() : __('messages.not_submitted') }}
    </span>
    <span style="color:#94a3b8;">|</span>
    <span style="color:#64748b; font-size:0.85rem;">
        <i class="fas fa-tag"></i> {{ __('messages.source') }}: <strong>{{ ucfirst($registration->source ?? __('messages.not_available')) }}</strong>
    </span>
</div>

{{-- ===== STATUS PROGRESSION BADGES ===== --}}
<div style="background:#fff; border-radius:12px; padding:12px 20px; box-shadow:0 1px 3px rgba(0,0,0,0.04); margin-bottom:24px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
    <span style="font-weight:600; color:#0f172a; font-size:0.85rem;">{{ __('messages.workflow_status') }}:</span>
    @php
        $hasInvoice = $registration->invoices->isNotEmpty();
        $hasPayment = $registration->payments->isNotEmpty();
        $paymentVerified = $hasPayment && $registration->payments->where('status', 'verified')->isNotEmpty();
        $hasReceipt = $registration->receipts->isNotEmpty();
        $statuses = [
            'registration' => true,
            'invoice' => $hasInvoice,
            'payment' => $hasPayment,
            'verified' => $paymentVerified,
            'receipt' => $hasReceipt,
        ];
    @endphp
    @foreach(['registration' => '📋', 'invoice' => '📄', 'payment' => '💳', 'verified' => '✅', 'receipt' => '🧾'] as $key => $icon)
        <span style="display:flex; align-items:center; gap:4px; padding:4px 12px; border-radius:50px; 
            {{ $statuses[$key] ? 'background:#dcfce7; color:#166534;' : 'background:#f1f5f9; color:#94a3b8;' }}
            font-size:0.75rem; font-weight:600;">
            {{ $icon }} {{ __('messages.step_'.$key) }}
        </span>
        @if(!$loop->last) <span style="color:#cbd5e1;">→</span> @endif
    @endforeach
</div>

{{-- ===== MAIN CONTENT: 2-COLUMN LAYOUT ===== --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">

    {{-- ===== LEFT COLUMN ===== --}}
    <div>

        {{-- Registration Details --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle"></i> {{ __('messages.registration_details') }}
            </div>
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.hostel_name') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->hostel_name ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.hostel_type') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ ucfirst($registration->hostel_type ?? __('messages.not_available')) }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.capacity') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->capacity ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.established_year') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->established_year ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.contact_number') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->contact ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.email') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->email ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.pan_number') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->pan ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.registration_number') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->registration_number ?? __('messages.not_available') }}</p></div>
                @if($registration->description)
                    <div style="grid-column:1/-1;">
                        <label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.description') }}</label>
                        <p style="color:#475569; margin:2px 0 0;">{{ $registration->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Address Details --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #64748B, #475569); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-map-marker-alt"></i> {{ __('messages.address_details') }}
            </div>
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.province') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->province ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.district') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->district ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.municipality') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->municipality ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.ward') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->ward ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.street') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->street ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.landmark') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $registration->landmark ?? __('messages.not_available') }}</p></div>
            </div>
        </div>

    </div>

    {{-- ===== RIGHT COLUMN (Sidebar) ===== --}}
    <div>

        {{-- Owner Details --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-user-circle"></i> {{ __('messages.owner_details') }}
            </div>
            <div style="padding:20px; text-align:center;">
                @php
                    $owner = null;
                    $source = null;
                    $sourceKey = null;

                    // 1. Registration owner (User)
                    if ($registration->owner) {
                        $owner = $registration->owner;
                        $source = __('messages.owner_source_registration');
                        $sourceKey = 'registration';
                    }
                    // 2. Registration operator_name (fallback string)
                    elseif (!empty($registration->operator_name)) {
                        $owner = (object) [
                            'name' => $registration->operator_name,
                            'email' => $registration->email ?? null,
                            'phone' => $registration->contact ?? null,
                            'citizenship_number' => null,
                            'pan' => null,
                        ];
                        $source = __('messages.owner_source_registration_name');
                        $sourceKey = 'registration_name';
                    }
                    // 3. Hostel owner (User)
                    elseif ($registration->hostel && $registration->hostel->owner) {
                        $owner = $registration->hostel->owner;
                        $source = __('messages.owner_source_hostel');
                        $sourceKey = 'hostel';
                    }
                    // 4. Hostel operator_name (fallback)
                    elseif ($registration->hostel && !empty($registration->hostel->operator_name)) {
                        $owner = (object) [
                            'name' => $registration->hostel->operator_name,
                            'email' => $registration->hostel->email ?? null,
                            'phone' => $registration->hostel->contact ?? null,
                            'citizenship_number' => null,
                            'pan' => null,
                        ];
                        $source = __('messages.owner_source_hostel_name');
                        $sourceKey = 'hostel_name';
                    }
                @endphp

                @if($owner)
                    {{-- Display owner --}}
                    <div style="width:70px; height:70px; border-radius:50%; background:#0EA5E9; color:#fff; display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:700; margin:0 auto 12px;">
                        {{ substr($owner->name, 0, 1) }}
                    </div>
                    <p style="font-weight:700; color:#0f172a; margin:0;">{{ $owner->name }}</p>
                    @if($owner->email)
                        <p style="color:#64748b; font-size:0.85rem; margin:2px 0 12px;">
                            <a href="mailto:{{ $owner->email }}" style="color:#0EA5E9; text-decoration:none;">{{ $owner->email }}</a>
                        </p>
                    @endif
                    <div style="display:grid; grid-template-columns:1fr; gap:8px; text-align:left; font-size:0.85rem; background:#f8fafc; padding:12px; border-radius:8px;">
                        <div><span style="color:#94a3b8; font-size:0.7rem; text-transform:uppercase;">{{ __('messages.phone') }}</span><br><strong>{{ $owner->phone ?? __('messages.not_available') }}</strong></div>
                    </div>
                    <div style="margin-top:12px;">
                        <span style="display:inline-block; background:#e2e8f0; color:#475569; padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                            <i class="fas fa-info-circle"></i> {{ __('messages.owner_source') }}: {{ $source }}
                        </span>
                    </div>
                @else
                    <div style="padding:20px;">
                        <i class="fas fa-user-slash" style="font-size:3rem; color:#cbd5e1;"></i>
                        <p style="color:#94a3b8; margin-top:8px;">{{ __('messages.no_owner_linked') }}</p>
                        @if($registration->status === 'approved')
                            <div style="background:#fef3c7; border-left:4px solid #F59E0B; padding:12px 16px; border-radius:8px; margin-top:12px; text-align:left;">
                                <i class="fas fa-exclamation-triangle" style="color:#F59E0B;"></i>
                                <span style="color:#92400e; font-weight:500;">{{ __('messages.owner_incomplete_warning') }}</span>
                                <a href="{{ route('admin.registrations.edit', $registration) }}" style="display:inline-block; margin-top:8px; background:#F59E0B; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem;">
                                    <i class="fas fa-user-plus"></i> {{ __('messages.add_owner') }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Stats --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="background:linear-gradient(135deg, #06B6D4, #0891B2); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-chart-simple"></i> {{ __('messages.quick_stats') }}
            </div>
            <div style="padding:16px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
                    <i class="fas fa-file-alt" style="color:#0EA5E9; font-size:1.3rem;"></i>
                    <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">{{ $registration->documents?->count() ?? 0 }}</div>
                    <span style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.documents') }}</span>
                </div>
                <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
                    <i class="fas fa-credit-card" style="color:#22C55E; font-size:1.3rem;"></i>
                    <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">{{ $registration->payments?->count() ?? 0 }}</div>
                    <span style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.payments') }}</span>
                </div>
                <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
                    <i class="fas fa-receipt" style="color:#F59E0B; font-size:1.3rem;"></i>
                    <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">{{ $registration->invoices?->count() ?? 0 }}</div>
                    <span style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.invoices') }}</span>
                </div>
                <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
                    <i class="fas fa-certificate" style="color:#EF4444; font-size:1.3rem;"></i>
                    <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">{{ $registration->certificates?->count() ?? 0 }}</div>
                    <span style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.certificates') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ACTIONS SECTION (अपडेटेड – Conditional Logic with Status Check) ===== --}}
<div style="margin-top:24px;">
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #1E293B, #0F172A); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-tools"></i> {{ __('messages.actions') }}
        </div>
        <div style="padding:20px;">
            <div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:16px;">

                @php
                    $hasInvoice = $registration->invoices->isNotEmpty();
                    $latestInvoice = $hasInvoice ? $registration->invoices->sortByDesc('id')->first() : null;
                    $invoicePaid = $latestInvoice && $latestInvoice->status === 'paid';
                    $hasPayment = $registration->payments->isNotEmpty();
                    $paymentVerified = $hasPayment && $registration->payments->where('status', 'verified')->isNotEmpty();
                    $verifiedPayment = $paymentVerified ? $registration->payments->where('status', 'verified')->first() : null;
                    $hasReceipt = $registration->receipts->isNotEmpty();
                    $isApproved = $registration->status === 'approved';
                    $isPending = $registration->status === 'pending';
                    $canGenerateInvoice = $isApproved && !$hasInvoice; // only approved & no invoice
                    $canAddPayment = $hasInvoice && !$invoicePaid;
                @endphp

                {{-- 1. APPROVE / REJECT (Pending मा मात्र) --}}
                @if($isPending)
                    <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(34,197,94,0.3);">
                            <i class="fas fa-check-circle"></i> {{ __('messages.approve') }}
                        </button>
                    </form>
                    <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:linear-gradient(135deg, #EF4444, #DC2626); color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(239,68,68,0.3);">
                            <i class="fas fa-times-circle"></i> {{ __('messages.reject') }}
                        </button>
                    </form>
                @endif

                {{-- 2. INVOICE WORKFLOW (अपडेटेड) --}}
                @if($canGenerateInvoice)
                    {{-- approved भएको र कुनै invoice छैन: Generate Invoice button --}}
                    <button type="button" onclick="document.getElementById('invoiceForm').style.display=document.getElementById('invoiceForm').style.display=='none'?'block':'none'"
                        style="background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(139,92,246,0.3);">
                        <i class="fas fa-file-invoice"></i> {{ __('messages.generate_invoice') }}
                    </button>
                @elseif($hasInvoice)
                    {{-- Invoice अवस्थित छ --}}
                    @if(!$invoicePaid)
                        {{-- पूर्ण भुक्तान भएको छैन: View Invoice + Add Payment --}}
                        @if($latestInvoice)
                            <a href="{{ route('admin.invoices.download', $latestInvoice->id) }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
                                <i class="fas fa-eye"></i> {{ __('messages.view_invoice') }}
                            </a>
                        @endif
                        <a href="{{ route('admin.payments.create', ['registration_id' => $registration->id]) }}" style="display:inline-flex; align-items:center; gap:8px; background:#22C55E; color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
                            <i class="fas fa-plus-circle"></i> {{ __('messages.add_payment') }}
                        </a>
                    @else
                        {{-- पूर्ण भुक्तान भएको छ --}}
                        @if(!$hasReceipt)
                            {{-- Receipt छैन: Generate Receipt (यदि verified payment छ भने) --}}
                            @if($verifiedPayment)
                                <form action="{{ route('admin.receipts.generate', $verifiedPayment) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                                        <i class="fas fa-receipt"></i> {{ __('messages.generate_receipt') }}
                                    </button>
                                </form>
                            @endif
                        @else
                            {{-- Receipt अवस्थित: View Receipt + Download Receipt --}}
                            @php $latestReceipt = $registration->receipts->sortByDesc('id')->first(); @endphp
                            @if($latestReceipt)
                                <a href="{{ route('admin.receipts.show', $latestReceipt) }}" style="display:inline-flex; align-items:center; gap:8px; background:#8B5CF6; color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
                                    <i class="fas fa-eye"></i> {{ __('messages.view_receipt') }}
                                </a>
                                <a href="{{ route('admin.receipts.download', $latestReceipt) }}" style="display:inline-flex; align-items:center; gap:8px; background:#22C55E; color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
                                    <i class="fas fa-download"></i> {{ __('messages.download_receipt') }}
                                </a>
                            @endif
                        @endif
                    @endif
                @else
                    {{-- यदि न approved हो न pending (active, expired, rejected etc.) – कुनै action नदेखाउने --}}
                    <span style="color:#94a3b8; font-size:0.9rem;">{{ __('messages.no_actions_available') }}</span>
                @endif

                {{-- 3. INSPECTOR & INSPECTION --}}
                <button type="button" onclick="document.getElementById('inspectorForm').style.display=document.getElementById('inspectorForm').style.display=='none'?'block':'none'"
                    style="background:linear-gradient(135deg, #06B6D4, #0891B2); color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(6,182,212,0.3);">
                    <i class="fas fa-user-check"></i> {{ __('messages.assign_inspector') }}
                </button>

                <a href="{{ route('admin.inspections.create', $registration) }}" style="display:inline-flex; align-items:center; gap:8px; background:#8B5CF6; color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
                    <i class="fas fa-clipboard-list"></i> {{ __('messages.start_inspection') }}
                </a>
            </div>

            {{-- Inspector Form --}}
            <div id="inspectorForm" style="display:none; background:#f8fafc; border-radius:12px; padding:20px; margin-bottom:12px;">
                <form action="{{ route('admin.registrations.assignInspector', $registration) }}" method="POST">
                    @csrf
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                        <div>
                            <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.inspector') }} <span style="color:#dc2626;">*</span></label>
                            <select name="inspector_id" required style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;">
                                <option value="">{{ __('messages.select_inspector') }}</option>
                                @forelse($inspectors ?? [] as $inspector)
                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @empty
                                    <option value="" disabled>{{ __('messages.no_inspectors_available') }}</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.scheduled_date') }} <span style="color:#dc2626;">*</span></label>
                            <input type="date" name="scheduled_date" required style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                        </div>
                        <div>
                            <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.remarks_optional') }}</label>
                            <input type="text" name="remarks" placeholder="{{ __('messages.remarks_placeholder_schedule') }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                        </div>
                    </div>
                    <div style="margin-top:12px; text-align:right;">
                        <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:10px 30px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                            <i class="fas fa-calendar-plus"></i> {{ __('messages.assign_and_schedule') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Invoice Form (hidden) – only shown when canGenerateInvoice is true --}}
            @if($canGenerateInvoice)
            <div id="invoiceForm" style="display:none; background:#f8fafc; border-radius:12px; padding:20px; margin-top:12px;">
                <form action="{{ route('admin.invoices.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                        <div>
                            <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.invoice_type') }} <span style="color:#dc2626;">*</span></label>
                            <select name="invoice_type" required style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;">
                                <option value="">{{ __('messages.select_type') }}</option>
                                <option value="new_registration">{{ __('messages.invoice_type_new_registration') }}</option>
                                <option value="renewal">{{ __('messages.invoice_type_renewal') }}</option>
                                <option value="membership_fee">{{ __('messages.invoice_type_membership_fee') }}</option>
                                <option value="inspection_fee">{{ __('messages.invoice_type_inspection_fee') }}</option>
                                <option value="certificate_fee">{{ __('messages.invoice_type_certificate_fee') }}</option>
                                <option value="penalty">{{ __('messages.invoice_type_penalty') }}</option>
                                <option value="other">{{ __('messages.invoice_type_other') }}</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.amount_npr') }} <span style="color:#dc2626;">*</span></label>
                            <input type="number" name="amount" step="0.01" required placeholder="{{ __('messages.placeholder_amount') }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                        </div>
                        <div>
                            <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.due_date') }}</label>
                            <input type="date" name="due_date" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                        </div>
                    </div>
                    <div style="margin-top:12px; text-align:right;">
                        <button type="submit" style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                            <i class="fas fa-file-invoice"></i> {{ __('messages.generate_invoice') }}
                        </button>
                    </div>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- ✅ FINANCIAL SUMMARY --}}
{{-- ============================================================ --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
    <h4 style="margin:0 0 16px 0; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-chart-pie" style="color:#0EA5E9;"></i> {{ __('messages.financial_summary') }}
    </h4>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px;">
        <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
            <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.total_invoiced') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">NPR {{ number_format($registration->total_invoiced, 2) }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
            <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.total_paid') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#22C55E;">NPR {{ number_format($registration->total_paid, 2) }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
            <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.outstanding') }}</div>
            <div style="font-weight:700; font-size:1.3rem; color:#EF4444;">NPR {{ number_format($registration->outstanding, 2) }}</div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:14px; border-radius:8px;">
            <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.latest_receipt') }}</div>
            @if($registration->latest_receipt)
                <a href="{{ route('admin.receipts.download', $registration->latest_receipt) }}" style="font-weight:700; color:#0EA5E9; text-decoration:none;">
                    {{ $registration->latest_receipt->receipt_number }}
                </a>
            @else
                <span style="color:#94a3b8;">{{ __('messages.none') }}</span>
            @endif
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- ✅ INVOICES, PAYMENTS, RECEIPTS GRID --}}
{{-- ============================================================ --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px;">

    {{-- Invoices --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-invoice"></i> {{ __('messages.invoices') }}
        </div>
        <div style="padding:16px;">
            @if($registration->invoices->count())
                @foreach($registration->invoices as $invoice)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                    <div>
                        <span style="font-weight:500;">{{ $invoice->invoice_number }}</span>
                        <br><span style="font-size:0.75rem; color:#94a3b8;">{{ __('messages.type') }}: {{ __('messages.invoice_type_'.$invoice->invoice_type) }}</span>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-weight:700;">NPR {{ number_format($invoice->amount, 2) }}</span>
                        <br><span style="font-size:0.75rem; padding:2px 8px; border-radius:50px; 
                            @if($invoice->status == 'paid') background:#dcfce7; color:#166534;
                            @elseif($invoice->status == 'partial') background:#fef3c7; color:#92400e;
                            @elseif($invoice->status == 'overdue') background:#fee2e2; color:#991b1b;
                            @else background:#e2e8f0; color:#475569; @endif">
                            {{ __('messages.status_'.$invoice->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center; padding:20px; color:#94a3b8;">{{ __('messages.no_invoices') }}</div>
            @endif
        </div>
    </div>

    {{-- Payments --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-credit-card"></i> {{ __('messages.payments') }}
        </div>
        <div style="padding:16px;">
            @if($registration->payments->count())
                @foreach($registration->payments as $payment)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                    <div>
                        <span style="font-weight:500;">{{ ucfirst($payment->method) }}</span>
                        <br><span style="font-size:0.75rem; color:#94a3b8;">{{ $payment->transaction_id ?? 'N/A' }}</span>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-weight:700;">NPR {{ number_format($payment->amount, 2) }}</span>
                        <br><span style="font-size:0.75rem; padding:2px 8px; border-radius:50px; 
                            @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                            @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                            @else background:#fee2e2; color:#991b1b; @endif">
                            {{ __('messages.status_'.$payment->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center; padding:20px; color:#94a3b8;">{{ __('messages.no_payments_recorded') }}</div>
            @endif
            <div style="margin-top:12px;">
                <a href="{{ route('admin.payments.create', ['registration_id' => $registration->id]) }}" style="display:inline-block; background:#22C55E; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem;">
                    <i class="fas fa-plus"></i> {{ __('messages.add_payment') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Receipts (full width) --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; grid-column:1/-1;">
        <div style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-receipt"></i> {{ __('messages.receipts') }}
        </div>
        <div style="padding:16px;">
            @if($registration->receipts->count())
                @foreach($registration->receipts as $receipt)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                    <div>
                        <span style="font-weight:500;">{{ $receipt->receipt_number }}</span>
                        <br><span style="font-size:0.75rem; color:#94a3b8;">{{ $receipt->issued_date->format('Y-m-d') }}</span>
                        <span style="font-size:0.75rem; color:#94a3b8; margin-left:12px;">NPR {{ number_format($receipt->amount, 2) }}</span>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <a href="{{ route('admin.receipts.show', $receipt) }}" style="background:#0EA5E9; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                            <i class="fas fa-eye"></i> {{ __('messages.view') }}
                        </a>
                        <a href="{{ route('admin.receipts.download', $receipt) }}" style="background:#22C55E; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                            <i class="fas fa-download"></i> {{ __('messages.download') }}
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center; padding:20px; color:#94a3b8;">{{ __('messages.no_receipts') }}</div>
            @endif
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- BOTTOM SECTIONS: Documents, Inspections, Duplicate Reviews --}}
{{-- ============================================================ --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px;">

    {{-- Documents --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-pdf"></i> {{ __('messages.documents') }}
        </div>
        <div style="padding:16px;">
            @if($registration->documents?->count())
                @foreach($registration->documents as $doc)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                        <div>
                            <span style="font-weight:500;">{{ ucfirst(str_replace('_', ' ', $doc->type)) }}</span>
                            <br><span style="font-size:0.75rem; color:#94a3b8;">{{ $doc->created_at->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ route('admin.documents.download', $doc->id) }}" style="background:#0EA5E9; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                            <i class="fas fa-download"></i> {{ __('messages.download') }}
                        </a>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:30px;">
                    <i class="fas fa-file-alt" style="font-size:2.5rem; color:#cbd5e1;"></i>
                    <p style="color:#94a3b8; margin-top:8px;">{{ __('messages.no_documents_uploaded') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Inspections --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-clipboard-check"></i> {{ __('messages.inspections') }}
        </div>
        <div style="padding:16px;">
            @if($registration->inspections?->count())
                @foreach($registration->inspections as $inspection)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                        <div>
                            <span style="font-weight:500;">{{ $inspection->scheduled_date }}</span>
                            <br><span style="font-size:0.75rem; color:#94a3b8;">{{ $inspection->remarks ?? __('messages.no_remarks') }}</span>
                        </div>
                        <span style="padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; 
                            @if($inspection->status == 'completed') background:#dcfce7; color:#166534;
                            @else background:#fef3c7; color:#92400e; @endif">
                            {{ __('messages.status_' . $inspection->status) }}
                        </span>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:30px;">
                    <i class="fas fa-clipboard-list" style="font-size:2.5rem; color:#cbd5e1;"></i>
                    <p style="color:#94a3b8; margin-top:8px;">{{ __('messages.no_inspections_scheduled') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Duplicate Reviews (full width) --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; grid-column:1/-1;">
        <div style="background:linear-gradient(135deg, #EF4444, #DC2626); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-copy"></i> {{ __('messages.duplicate_reviews') }}
        </div>
        <div style="padding:16px;">
            @if($registration->duplicateReviews?->count())
                @foreach($registration->duplicateReviews as $review)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                        <div>
                            <span style="font-weight:500;">{{ $review->reviewedBy->name ?? __('messages.not_available') }}</span>
                            <br><span style="font-size:0.75rem; color:#94a3b8;">{{ $review->notes ?? __('messages.no_notes') }}</span>
                        </div>
                        <span style="padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; 
                            @if($review->is_duplicate) background:#fee2e2; color:#991b1b;
                            @else background:#dcfce7; color:#166534; @endif">
                            {{ $review->is_duplicate ? __('messages.yes') : __('messages.no') }}
                        </span>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:30px;">
                    <i class="fas fa-copy" style="font-size:2.5rem; color:#cbd5e1;"></i>
                    <p style="color:#94a3b8; margin-top:8px;">{{ __('messages.no_duplicate_reviews') }}</p>
                </div>
            @endif

            <div style="margin-top:12px; display:flex; gap:8px;">
                <form action="{{ route('admin.duplicate.review', $registration) }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_duplicate" value="0">
                    <button type="submit" style="background:#22C55E; color:#fff; border:none; padding:6px 18px; border-radius:50px; font-weight:600; font-size:0.8rem; cursor:pointer; transition:0.3s;">
                        <i class="fas fa-check"></i> {{ __('messages.not_duplicate') }}
                    </button>
                </form>
                <form action="{{ route('admin.duplicate.review', $registration) }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_duplicate" value="1">
                    <button type="submit" style="background:#EF4444; color:#fff; border:none; padding:6px 18px; border-radius:50px; font-weight:600; font-size:0.8rem; cursor:pointer; transition:0.3s;">
                        <i class="fas fa-exclamation-triangle"></i> {{ __('messages.mark_as_duplicate') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection