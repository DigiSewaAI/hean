@php dd($inspection->photos); @endphp
@extends('layouts.admin')

@section('title', __('messages.inspection') . ' #' . $inspection->id . ' - HEAN Admin')

@section('content')
<div style="max-width:1000px; margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-clipboard-check" style="color:#8B5CF6;"></i>
            {{ __('messages.inspection') }} #{{ $inspection->id }}
            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                {{ $inspection->created_at ? $inspection->created_at->format('M d, Y') : __('messages.not_available') }}
            </span>
        </h2>
        <div>
            <a href="{{ route('admin.registrations.show', $inspection->registration_id) }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_registration') }}
            </a>
        </div>
    </div>

    {{-- Status Badge --}}
    <div style="margin-bottom:20px;">
        @php
            $statusColors = [
                'scheduled' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'completed' => ['bg' => '#dcfce7', 'text' => '#166534'],
                'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            ];
            $colors = $statusColors[$inspection->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
        @endphp
        <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.9rem; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
            <span style="width:10px; height:10px; border-radius:50%; display:inline-block; background:{{ $colors['text'] }};"></span>
            {{ __('messages.status_' . $inspection->status) }}
        </span>
    </div>

    {{-- Main Content --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        {{-- Inspection Details --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle" style="color:#8B5CF6;"></i> {{ __('messages.inspection_details') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.inspector') }}</span>
                    <br><strong style="color:#0f172a;">{{ $inspection->inspector->name ?? 'N/A' }}</strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.scheduled_date') }}</span>
                    <br><strong style="color:#0f172a;">{{ $inspection->scheduled_date ?? 'N/A' }}</strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.status') }}</span>
                    <br>
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.8rem; font-weight:600; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
                        {{ __('messages.status_' . $inspection->status) }}
                    </span>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.completed_date') }}</span>
                    <br><strong style="color:#0f172a;">{{ $inspection->completed_date ? $inspection->completed_date->format('Y-m-d') : 'N/A' }}</strong>
                </div>
                @if($inspection->remarks)
                <div style="grid-column:1/-1;">
                    <span style="font-weight:600; color:#475569;">{{ __('messages.remarks') }}</span>
                    <br><span style="color:#0f172a;">{{ $inspection->remarks }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Registration Info --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-file-alt" style="color:#0EA5E9;"></i> {{ __('messages.registration') }}
            </h4>
            @if($inspection->registration)
                <p style="margin:4px 0; font-weight:600; color:#0f172a;">{{ $inspection->registration->hostel_name ?? $inspection->registration->registration_number }}</p>
                <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                    <i class="fas fa-hashtag"></i> {{ $inspection->registration->registration_number }}
                </p>
                <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                    <i class="fas fa-map-marker-alt"></i> {{ $inspection->registration->district }}, {{ $inspection->registration->municipality }}
                </p>
                <a href="{{ route('admin.registrations.show', $inspection->registration) }}" style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem; margin-top:8px;">
                    <i class="fas fa-eye"></i> {{ __('messages.view_registration') }}
                </a>
            @else
                <p style="color:#94a3b8;">{{ __('messages.not_available') }}</p>
            @endif
        </div>
    </div>

    {{-- ✅ Checklist with Labels --}}
    @if(!empty($checklist) && is_array($checklist))
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
        <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-list" style="color:#8B5CF6;"></i> {{ __('messages.inspection_checklist') }}
        </h4>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
            @foreach($checklist as $key => $value)
                @php
                    // Get the label from criteriaLabels array
                    $label = $criteriaLabels[$key] ?? 'Criteria ' . $key;
                    // Get remark for this item
                    $remark = $checklistRemarks[$key] ?? null;
                @endphp
                <div style="display:flex; align-items:center; gap:8px; padding:6px 12px; background:#f8fafc; border-radius:6px;">
                    <span style="font-weight:600; color:#0f172a; min-width:20px;">{{ $loop->iteration }}.</span>
                    <span style="flex:1; color:#475569; font-size:0.85rem;">{{ $label }}</span>
                    <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                        @if($value == 'yes') background:#dcfce7; color:#166534;
                        @elseif($value == 'no') background:#fee2e2; color:#991b1b;
                        @else background:#f1f5f9; color:#475569; @endif">
                        {{ ucfirst($value) }}
                    </span>
                    @if($remark)
                        <span style="font-size:0.65rem; color:#64748b; margin-left:4px;" title="{{ $remark }}">
                            <i class="fas fa-comment"></i>
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Photos --}}
@php
    $photos = $inspection->photos ?? [];
    if (is_string($photos)) {
        $photos = json_decode($photos, true);
    }
@endphp
@if(!empty($photos) && is_array($photos))
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
    <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-camera" style="color:#F59E0B;"></i> {{ __('messages.inspection_photos') }}
    </h4>
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(150px, 1fr)); gap:12px;">
        @foreach($photos as $photo)
            {{-- Remove 'public/' prefix if present --}}
            @php
                $cleanPath = str_replace('public/', '', $photo);
            @endphp
            <div style="border-radius:8px; overflow:hidden; border:1px solid #e2e8f0;">
                <img src="{{ asset('storage/' . $cleanPath) }}" alt="Inspection Photo" style="width:100%; height:120px; object-fit:cover;">
            </div>
        @endforeach
    </div>
</div>
@endif

    {{-- Actions --}}
    <div style="margin-top:24px; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px 20px; display:flex; gap:12px; flex-wrap:wrap;">
        <a href="{{ route('admin.registrations.show', $inspection->registration_id) }}" style="display:inline-flex; align-items:center; gap:6px; background:#0EA5E9; color:#fff; padding:8px 24px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem;">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_registration') }}
        </a>
    </div>

</div>
@endsection