@extends('layouts.admin')

@section('title', __('messages.admin_inspections_title') . ' - HEAN Admin')

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#8B5CF6; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-clipboard-list" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $totalInspections ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_inspections') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#22C55E; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-check-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $completedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_completed') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#F59E0B; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-clock" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $scheduledCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_scheduled') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#EF4444; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-times-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $cancelledCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_cancelled') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS + ACTIONS ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.inspections.index') }}" method="GET" id="filterForm">
        {{-- Basic Search & Quick Filters --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#8B5CF6;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="होस्टल नाम, दर्ता नम्बर, निरीक्षक नाम..." 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Status --}}
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.status') }}</label>
                <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>{{ __('messages.status_completed') }}</option>
                    <option value="scheduled" {{ request('status')=='scheduled'?'selected':'' }}>{{ __('messages.status_scheduled') }}</option>
                    <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>{{ __('messages.status_cancelled') }}</option>
                </select>
            </div>

            {{-- Sort --}}
            <div style="flex:1; min-width:130px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.sort_by') }}</label>
                <select name="sort" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>{{ __('messages.sort_latest') }}</option>
                    <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>{{ __('messages.sort_oldest') }}</option>
                    <option value="status_asc" {{ request('sort')=='status_asc'?'selected':'' }}>{{ __('messages.sort_status_asc') }}</option>
                    <option value="status_desc" {{ request('sort')=='status_desc'?'selected':'' }}>{{ __('messages.sort_status_desc') }}</option>
                    <option value="date_asc" {{ request('sort')=='date_asc'?'selected':'' }}>{{ __('messages.sort_date_asc') }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <button type="submit" style="background:linear-gradient(135deg, #8B5CF6, #6366F1); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(139,92,246,0.25);">
                    <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                </button>
                <a href="{{ route('admin.inspections.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-undo"></i> {{ __('messages.reset') }}
                </a>
                <button type="button" onclick="document.getElementById('advancedFilters').style.display = (document.getElementById('advancedFilters').style.display === 'none' ? 'block' : 'none')" 
                        style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0; padding:10px 16px; border-radius:50px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:0.2s;">
                    <i class="fas fa-sliders-h"></i> {{ __('messages.advanced') }}
                </button>
            </div>
        </div>

        {{-- Advanced Filters (collapsible) --}}
        <div id="advancedFilters" style="display: {{ request()->hasAny(['inspector_id', 'registration_id', 'date_from', 'date_to']) ? 'block' : 'none' }}; margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
                {{-- Inspector Dropdown --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.inspector') }}</label>
                    <select name="inspector_id" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($inspectors as $inspector)
                            <option value="{{ $inspector->id }}" {{ request('inspector_id')==$inspector->id?'selected':'' }}>{{ $inspector->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Registration Dropdown --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.registration') }}</label>
                    <select name="registration_id" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($registrations as $reg)
                            <option value="{{ $reg->id }}" {{ request('registration_id')==$reg->id?'selected':'' }}>
                                {{ $reg->registration_number }} - {{ $reg->hostel_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date From --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_from') }}</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- Date To --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_to') }}</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ===== NEW INSPECTION BUTTON ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
    <div style="font-size:0.9rem; color:#64748b;">
        <i class="fas fa-info-circle"></i> 
        {{ __('messages.showing_inspections', ['total' => $inspections->total(), 'from' => $inspections->firstItem() ?? 0, 'to' => $inspections->lastItem() ?? 0]) }}
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.inspections.select') }}" 
           style="display:inline-flex; align-items:center; gap:8px; 
                  background:linear-gradient(135deg, #8B5CF6, #6366F1); 
                  color:#fff; padding:10px 24px; border-radius:50px; 
                  text-decoration:none; font-weight:600; font-size:0.9rem; 
                  box-shadow:0 4px 15px rgba(139,92,246,0.3); 
                  transition:0.3s;">
            <i class="fas fa-plus-circle"></i> {{ __('messages.new_inspection') }}
        </a>
        <a href="{{ route('admin.registrations.index') }}" 
           style="display:inline-flex; align-items:center; gap:6px; 
                  background:#e2e8f0; color:#1e293b; padding:8px 18px; 
                  border-radius:50px; text-decoration:none; font-weight:500; 
                  font-size:0.85rem; transition:0.3s;">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_registrations') }}
        </a>
    </div>
</div>

{{-- ===== TABLE ===== --}}
<div style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.registration') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.hostel') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.inspector') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.completed_date') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.status') }}</th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inspections as $inspection)
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">{{ $loop->iteration + ($inspections->currentPage() - 1) * $inspections->perPage() }}</td>
                <td style="padding:12px 16px;">
                    @if($inspection->registration)
                        <a href="{{ route('admin.registrations.show', $inspection->registration) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                            {{ $inspection->registration->registration_number ?? '#'.$inspection->registration->id }}
                        </a>
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">
                    {{ $inspection->registration->hostel_name ?? __('messages.not_available') }}
                    @if($inspection->registration && $inspection->registration->district)
                        <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $inspection->registration->district }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px;">{{ $inspection->inspector->name ?? __('messages.not_available') }}</td>
                <td style="padding:12px 16px; color:#64748b;">
                    @if($inspection->completed_date)
                        {{ $inspection->completed_date->format('Y-m-d') }}
                    @else
                        <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
                <td style="padding:12px 16px;">
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                        @if($inspection->status == 'completed') background:#dcfce7; color:#166534;
                        @elseif($inspection->status == 'scheduled') background:#fef3c7; color:#92400e;
                        @elseif($inspection->status == 'cancelled') background:#fee2e2; color:#991b1b;
                        @else background:#f1f5f9; color:#475569; @endif">
                        {{ __('messages.status_' . $inspection->status) }}
                    </span>
                </td>
                <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                    <a href="{{ route('admin.inspections.view', $inspection) }}" 
                       style="display:inline-block; padding:6px 14px; background:#8B5CF6; color:#fff; 
                              border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                        <i class="fas fa-eye"></i> {{ __('messages.view') }}
                    </a>
                    <a href="{{ route('admin.registrations.show', $inspection->registration_id) }}" 
                       style="display:inline-block; padding:6px 14px; background:#0EA5E9; color:#fff; 
                              border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                        <i class="fas fa-file-alt"></i> {{ __('messages.details') }}
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-clipboard-list" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    {{ __('messages.no_inspections_found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
    <span style="color:#64748b; font-size:0.85rem;">
        {{ __('messages.showing') }} {{ $inspections->firstItem() ?? 0 }} - {{ $inspections->lastItem() ?? 0 }} {{ __('messages.of') }} {{ $inspections->total() }}
    </span>
    <div>
        {{ $inspections->appends(request()->query())->links() }}
    </div>
</div>

@endsection

@push('styles')
<style>
    tbody tr:hover {
        background: #f8fafc;
    }
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
        border-color: #8B5CF6;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #8B5CF6, #6366F1);
        border-color: #8B5CF6;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush