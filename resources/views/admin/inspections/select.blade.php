@extends('layouts.admin')

@section('title', __('messages.inspection_select_title') . ' - HEAN Admin')

@section('content')
<div style="max-width:900px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
            <i class="fas fa-search" style="color:#8B5CF6;"></i> {{ __('messages.inspection_select_heading') }}
        </h2>
        <a href="{{ route('admin.inspections.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
        </a>
    </div>

    {{-- ✅ SEARCH FORM --}}
    <div style="margin-bottom:20px;">
        <form method="GET" action="{{ route('admin.inspections.select') }}" style="display:flex; gap:10px; flex-wrap:wrap;">
            <div style="flex:1; min-width:200px;">
                <div style="display:flex; gap:8px; align-items:center; background:#f1f5f9; border-radius:50px; padding:4px 4px 4px 18px;">
                    <input type="text" name="search" 
                           placeholder="Search by hostel name, registration number, district..." 
                           value="{{ request('search') }}"
                           style="flex:1; border:none; background:transparent; padding:10px 0; font-size:0.95rem; outline:none;">
                    <button type="submit" style="background:#8B5CF6; color:#fff; border:none; padding:8px 20px; border-radius:50px; font-weight:600; cursor:pointer;">
                        <i class="fas fa-search"></i> खोजी
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.inspections.select') }}" 
                           style="color:#64748b; padding:8px 12px; border-radius:50px; text-decoration:none; font-size:0.85rem;">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        @forelse($registrations as $reg)
        <a href="{{ route('admin.inspections.create', $reg) }}" 
           style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; margin-bottom:10px; background:#f8fafc; border-radius:8px; text-decoration:none; color:#0f172a; border:1px solid #e2e8f0; transition:0.2s;">
            <div>
                <strong>{{ $reg->hostel_name }}</strong>
                <span style="color:#64748b; font-size:0.85rem; margin-left:12px;">{{ $reg->district }}</span>
                <br>
                {{-- ✅ FULL REGISTRATION NUMBER --}}
                <span style="font-size:0.75rem; color:#94a3b8;">
                    {{ $reg->registration_number ?? __('messages.registration_no') . '#' . $reg->id }}
                    · {{ $reg->created_at->format('Y-m-d') }}
                </span>
            </div>
            <span style="padding:4px 14px; border-radius:50px; font-size:0.7rem; font-weight:600;
                @if($reg->status == 'pending') background:#fef3c7; color:#92400e;
                @elseif($reg->status == 'inspection') background:#fef3c7; color:#92400e;
                @else background:#e2e8f0; color:#475569; @endif">
                {{ __('messages.status_' . $reg->status) }}
            </span>
        </a>
        @empty
        <div style="text-align:center; padding:40px; color:#94a3b8;">
            <i class="fas fa-inbox" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:12px;"></i>
            {{ __('messages.no_inspection_applications') }}
        </div>
        @endforelse
    </div>
</div>
@endsection