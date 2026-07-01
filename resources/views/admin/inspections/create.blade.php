@extends('layouts.admin')

@section('title', __('messages.inspection_form_title') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-clipboard-list me-2" style="color:#8B5CF6;"></i> {{ __('messages.inspection_form_heading') }}
    </h2>
    <a href="{{ route('admin.registrations.show', $registration) }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.inspections.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="registration_id" value="{{ $registration->id }}">

        {{-- होस्टेल र निरीक्षक जानकारी --}}
        <div style="background:#f8fafc; padding:16px 20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6; display:flex; flex-wrap:wrap; gap:24px;">
            <div><strong>{{ __('messages.hostel') }}:</strong> {{ $registration->hostel_name }} ({{ $registration->district ?? __('messages.not_available') }}{{ $registration->ward ? '–'.$registration->ward : '' }})</div>
            <div><strong>{{ __('messages.inspector') }}:</strong> {{ auth()->user()->name ?? __('messages.not_available') }}</div>
            <div><strong>{{ __('messages.date') }}:</strong> {{ now()->format('Y-m-d') }}</div>
        </div>

        {{-- चेकलिस्ट तालिका --}}
        <div style="overflow-x:auto; margin-bottom:24px;">
            <table style="width:100%; border-collapse:collapse; font-size:0.9rem; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <thead style="background:#f1f5f9;">
                    <tr>
                        <th style="padding:10px 14px; text-align:left; font-weight:600; color:#475569; width:60px;">{{ __('messages.sn') }}</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:600; color:#475569;">{{ __('messages.inspection_criteria') }}</th>
                        <th style="padding:10px 14px; text-align:center; font-weight:600; color:#475569; width:80px;">{{ __('messages.yes') }}</th>
                        <th style="padding:10px 14px; text-align:center; font-weight:600; color:#475569; width:80px;">{{ __('messages.no') }}</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:600; color:#475569;">{{ __('messages.remarks') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $checklist = [
                            1 => __('messages.inspection_checklist_1'),
                            2 => __('messages.inspection_checklist_2'),
                            3 => __('messages.inspection_checklist_3'),
                            4 => __('messages.inspection_checklist_4'),
                            5 => __('messages.inspection_checklist_5'),
                            6 => __('messages.inspection_checklist_6'),
                            7 => __('messages.inspection_checklist_7'),
                            8 => __('messages.inspection_checklist_8'),
                            9 => __('messages.inspection_checklist_9'),
                            10 => __('messages.inspection_checklist_10'),
                            11 => __('messages.inspection_checklist_11'),
                        ];
                    @endphp

                    @foreach($checklist as $key => $label)
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:10px 14px; font-weight:600; color:#0f172a;">{{ $key }}</td>
                        <td style="padding:10px 14px; color:#1e293b;">{{ $label }}</td>
                        <td style="padding:10px 14px; text-align:center;">
                            <input type="radio" name="checklist[{{ $key }}]" value="yes" id="yes_{{ $key }}" style="width:18px; height:18px; accent-color:#10B981;">
                        </td>
                        <td style="padding:10px 14px; text-align:center;">
                            <input type="radio" name="checklist[{{ $key }}]" value="no" id="no_{{ $key }}" style="width:18px; height:18px; accent-color:#EF4444;">
                        </td>
                        <td style="padding:10px 14px;">
                            <input type="text" name="remarks[{{ $key }}]" placeholder="{{ __('messages.remarks_placeholder') }}" style="width:100%; padding:6px 10px; border:1px solid #e2e8f0; border-radius:6px; font-size:0.85rem;">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- फोटो अपलोड --}}
        <div style="background:#f8fafc; padding:16px 20px; border-radius:12px; margin-bottom:20px; border-left:4px solid #F59E0B;">
            <h5 style="margin:0 0 12px 0; font-size:0.95rem; color:#92400e;">
                <i class="fas fa-camera me-2"></i> {{ __('messages.inspection_photos') }}
            </h5>
            <input type="file" name="photos[]" id="photos" accept=".jpg,.jpeg,.png" multiple style="padding:8px 0;">
            <small style="color:#64748b; display:block; font-size:0.75rem;">{{ __('messages.photo_upload_instructions') }}</small>
        </div>

        {{-- डिजिटल हस्ताक्षर --}}
        <div style="background:#f8fafc; padding:16px 20px; border-radius:12px; margin-bottom:20px; border-left:4px solid #6366F1;">
            <h5 style="margin:0 0 12px 0; font-size:0.95rem; color:#4338ca;">
                <i class="fas fa-pen-fancy me-2"></i> {{ __('messages.digital_signature_heading') }}
            </h5>
            <div style="display:flex; gap:16px; flex-wrap:wrap;">
                <input type="text" name="signature" id="signature" placeholder="{{ __('messages.signature_placeholder') }}" style="flex:1; min-width:200px; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" required>
                <div style="display:flex; align-items:center; gap:8px; background:#eef2ff; padding:4px 16px; border-radius:50px;">
                    <span style="font-weight:600; color:#4338ca;">{{ auth()->user()->name ?? __('messages.not_available') }}</span>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #8B5CF6, #6366F1); color:#fff; padding:12px 32px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(99,102,241,0.3);">
                <i class="fas fa-check-circle"></i> {{ __('messages.submit_inspection') }}
            </button>
            <a href="{{ route('admin.registrations.show', $registration) }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:12px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>

{{-- फुटर --}}
<div style="margin-top:24px; text-align:center; color:#94a3b8; font-size:0.8rem; border-top:1px solid #e2e8f0; padding-top:16px;">
    {{ __('messages.inspection_footer') }}
</div>

@endsection