@extends('layouts.admin')

@section('title', __('messages.admin_registrations_title') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">{{ __('messages.admin_registrations_title') }}</h2>
    <a href="{{ route('admin.registrations.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> {{ __('messages.new_registration') }}
    </a>
</div>

{{-- ===== TABLE ===== --}}
<div class="table-container" style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.hostel') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.district') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.status') }}</th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;">{{ $reg->id }}</td>

                {{-- ✅ English name priority, fallback to Nepali --}}
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">
                    {{ $reg->hostel_name_english ?: $reg->hostel_name }}
                    @if($reg->hostel_name_english && $reg->hostel_name && $reg->hostel_name_english != $reg->hostel_name)
                        <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $reg->hostel_name }}</span>
                    @endif
                </td>

                <td style="padding:12px 16px; color:#475569;">{{ $reg->district ?? __('messages.not_available') }}</td>
                <td style="padding:12px 16px;">
                    @php
                        $statusColor = [
                            'approved' => ['bg' => '#dcfce7', 'text' => '#166534'],
                            'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                            'inspection' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                            'pending' => ['bg' => '#e2e8f0', 'text' => '#475569'],
                        ][$reg->status] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
                    @endphp
                    <span style="padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; background:{{ $statusColor['bg'] }}; color:{{ $statusColor['text'] }};">
                        {{ __('messages.status_' . $reg->status) }}
                    </span>
                </td>
                <td style="padding:12px 16px; text-align:center;">
                    <a href="{{ route('admin.registrations.show', $reg) }}" style="display:inline-block; padding:6px 14px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600; transition:0.2s;">
                        <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-file-alt" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    {{ __('messages.no_registrations') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:center;">
    {{ $registrations->links() }}
</div>

@endsection

@push('styles')
<style>
    /* Pagination custom style */
    .pagination-wrapper .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination-wrapper .pagination .page-item .page-link {
        padding: 8px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        transition: 0.2s;
        font-weight: 500;
        font-size: 0.9rem;
        background: #fff;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        border-color: #0EA5E9;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0EA5E9, #3B82F6);
        border-color: #0EA5E9;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush