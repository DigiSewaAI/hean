@extends('layouts.admin')

@section('title', __('messages.admin_hostels_title') . ' - HEAN Admin')

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#0EA5E9; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-hotel" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $totalHostels ?? $hostels->total() }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_hostels') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#22C55E; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-check-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $approvedCount ?? $hostels->where('approved', true)->count() }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.approved') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#F59E0B; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-star" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $featuredCount ?? $hostels->where('featured', true)->count() }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.featured') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#8B5CF6; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-eye" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $visibleCount ?? $hostels->where('visible', true)->count() }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.visible') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS + ACTIONS (Advanced + Collapsible) ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.hostels.index') }}" method="GET" id="filterForm">
        {{-- Basic Search & Quick Filters (always visible) --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#0EA5E9;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_placeholder_hostel') }} (नाम, ठेगाना, दर्ता नम्बर)" 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Status --}}
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.status') }}</label>
                <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="approved" {{ request('status')=='approved'?'selected':'' }}>{{ __('messages.status_approved') }}</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ __('messages.status_pending') }}</option>
                    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>{{ __('messages.status_rejected') }}</option>
                </select>
            </div>

            {{-- Filter: Featured --}}
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.featured') }}</label>
                <select name="featured" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="1" {{ request('featured')=='1'?'selected':'' }}>{{ __('messages.featured') }}</option>
                    <option value="0" {{ request('featured')=='0'?'selected':'' }}>{{ __('messages.normal') }}</option>
                </select>
            </div>

            {{-- Filter: Visibility --}}
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.visibility') }}</label>
                <select name="visible" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="1" {{ request('visible')=='1'?'selected':'' }}>{{ __('messages.visible') }}</option>
                    <option value="0" {{ request('visible')=='0'?'selected':'' }}>{{ __('messages.hidden') }}</option>
                </select>
            </div>

            {{-- Filter: Type --}}
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.type') }}</label>
                <select name="type" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="boys" {{ request('type')=='boys'?'selected':'' }}>{{ __('messages.boys') }}</option>
                    <option value="girls" {{ request('type')=='girls'?'selected':'' }}>{{ __('messages.girls') }}</option>
                    <option value="co-ed" {{ request('type')=='co-ed'?'selected':'' }}>{{ __('messages.co_ed') }}</option>
                </select>
            </div>

            {{-- Sort --}}
            <div style="flex:1; min-width:130px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.sort_by') }}</label>
                <select name="sort" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>{{ __('messages.sort_latest') }}</option>
                    <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>{{ __('messages.sort_oldest') }}</option>
                    <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>{{ __('messages.sort_name_asc') }}</option>
                    <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>{{ __('messages.sort_name_desc') }}</option>
                    <option value="district_asc" {{ request('sort')=='district_asc'?'selected':'' }}>{{ __('messages.sort_district_asc') }}</option>
                    <option value="capacity_desc" {{ request('sort')=='capacity_desc'?'selected':'' }}>{{ __('messages.sort_capacity_desc') }}</option>
                    <option value="capacity_asc" {{ request('sort')=='capacity_asc'?'selected':'' }}>{{ __('messages.sort_capacity_asc') }}</option>
                    {{-- ✅ नयाँ: दर्ता नम्बर अनुसार क्रमबद्ध --}}
                    <option value="reg_number_asc" {{ request('sort')=='reg_number_asc'?'selected':'' }}>{{ __('messages.sort_reg_number_asc') ?? 'Reg. Number (A-Z)' }}</option>
                    <option value="reg_number_desc" {{ request('sort')=='reg_number_desc'?'selected':'' }}>{{ __('messages.sort_reg_number_desc') ?? 'Reg. Number (Z-A)' }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
    <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.25);">
        <i class="fas fa-filter"></i> {{ __('messages.filter') }}
    </button>
    <a href="{{ route('admin.hostels.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
        <i class="fas fa-undo"></i> {{ __('messages.reset') }}
    </a>
    <button type="button" onclick="document.getElementById('advancedFilters').style.display = (document.getElementById('advancedFilters').style.display === 'none' ? 'block' : 'none')" 
            style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0; padding:10px 16px; border-radius:50px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:0.2s;">
        <i class="fas fa-sliders-h"></i> {{ __('messages.advanced') }}
    </button>
    <a href="{{ route('admin.hostels.export', request()->query()) }}" 
       style="display:inline-flex; align-items:center; gap:6px; background:#22C55E; color:#fff; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; margin-left:4px;">
        <i class="fas fa-file-excel"></i> {{ __('messages.export_excel') }}
    </a>
</div>

        {{-- ===== ADVANCED FILTERS (Collapsible) ===== --}}
        <div id="advancedFilters" style="display: {{ request()->hasAny(['local_reg_number', 'capacity_min', 'capacity_max', 'date_from', 'date_to', 'district']) ? 'block' : 'none' }}; margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
                {{-- Local Registration Number --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.local_reg_number') ?? 'स्थानीय दर्ता नम्बर' }}</label>
                    <input type="text" name="local_reg_number" value="{{ request('local_reg_number') }}" placeholder="KMC-W31-2082-..." 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- District Dropdown (Dynamic) --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.district') }}</label>
                    <select name="district" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist }}" {{ request('district')==$dist?'selected':'' }}>{{ $dist }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Capacity Min --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.capacity_min') ?? 'न्यूनतम क्षमता' }}</label>
                    <input type="number" name="capacity_min" value="{{ request('capacity_min') }}" placeholder="Min" min="0" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- Capacity Max --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.capacity_max') ?? 'अधिकतम क्षमता' }}</label>
                    <input type="number" name="capacity_max" value="{{ request('capacity_max') }}" placeholder="Max" min="0" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- Date From --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_from') ?? 'सुरु मिति' }}</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- Date To --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_to') ?? 'अन्त्य मिति' }}</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ===== NEW HOSTEL BUTTON ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
    <div style="font-size:0.9rem; color:#64748b;">
        <i class="fas fa-info-circle"></i> 
        {{ __('messages.showing_hostels', ['total' => $hostels->total(), 'from' => $hostels->firstItem() ?? 0, 'to' => $hostels->lastItem() ?? 0]) }}
    </div>
    <a href="{{ route('admin.hostels.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> {{ __('messages.add_new') }}
    </a>
</div>

{{-- ===== TABLE ===== --}}
<div class="table-container" style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <form action="{{ route('admin.test.bulk') }}" method="POST" onsubmit="return confirmBulkAction();">
        @csrf

        <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <tr>
                    <th style="padding:12px 16px; text-align:left; width:40px;">
                        <input type="checkbox" id="selectAll" style="accent-color:#0EA5E9; width:16px; height:16px; cursor:pointer;">
                    </th>
                    {{-- ✅ 8.3: दर्ता नम्बर स्तम्भ --}}
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">
                        दर्ता नम्बर
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.hostel') }}</th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.district') }}</th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.type') }}</th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.capacity') }}</th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.status') }}</th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.featured') }}</th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.visible') }}</th>
                    <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hostels as $hostel)
                <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                    <td style="padding:12px 16px; text-align:center;">
                        <input type="checkbox" name="ids[]" value="{{ $hostel->id }}" class="rowCheckbox" style="accent-color:#0EA5E9; width:16px; height:16px; cursor:pointer;">
                    </td>
                    {{-- ✅ 8.3: दर्ता नम्बर लिङ्कको रूपमा --}}
                    <td style="padding:12px 16px; font-weight:600; color:#0f172a;">
                        <a href="{{ route('admin.hostels.show', $hostel) }}" style="color:#0EA5E9; text-decoration:none; font-weight:600;">
                            {{ $hostel->registration_number }}
                        </a>
                    </td>
                    <td style="padding:12px 16px; font-weight:500; color:#0f172a;">
                        {{ $hostel->name_english ?: $hostel->name_nepali }}
                        @if($hostel->name_english && $hostel->name_nepali && $hostel->name_english != $hostel->name_nepali)
                            <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $hostel->name_nepali }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px; color:#475569;">{{ $hostel->district }}</td>
                    <td style="padding:12px 16px;">
                        <span style="background:rgba(14,165,233,0.1); color:#0EA5E9; padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                            {{ __($hostel->type ? 'messages.type_' . $hostel->type : 'messages.not_available') }}
                        </span>
                    </td>
                    <td style="padding:12px 16px; font-weight:600; color:#0f172a;">{{ $hostel->capacity ?? 0 }}</td>
                    <td style="padding:12px 16px;">
                        @if($hostel->approved)
                            <span style="background:#dcfce7; color:#166534; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                                <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> {{ __('messages.status_approved') }}
                            </span>
                        @else
                            <span style="background:#fef3c7; color:#92400e; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                                <i class="fas fa-clock" style="font-size:0.65rem;"></i> {{ __('messages.status_pending') }}
                            </span>
                        @endif
                    </td>
                    <td style="padding:12px 16px; text-align:center;">
                        @if($hostel->featured)
                            <span style="color:#F59E0B; font-size:1.1rem;" title="{{ __('messages.featured') }}">⭐</span>
                        @else
                            <span style="color:#cbd5e1; font-size:0.9rem;">—</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px; text-align:center;">
                        @if($hostel->visible)
                            <span style="color:#0EA5E9; font-size:1.1rem;" title="{{ __('messages.visible') }}">👁️</span>
                        @else
                            <span style="color:#94a3b8; font-size:1rem;" title="{{ __('messages.hidden') }}">🚫</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                        <a href="{{ route('admin.hostels.show', $hostel) }}" style="display:inline-block; padding:4px 10px; background:#0EA5E9; color:#fff; border-radius:6px; text-decoration:none; font-size:0.7rem; font-weight:600; margin-right:4px; transition:0.2s;" title="{{ __('messages.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.hostels.edit', $hostel) }}" style="display:inline-block; padding:4px 10px; background:#F59E0B; color:#fff; border-radius:6px; text-decoration:none; font-size:0.7rem; font-weight:600; margin-right:4px; transition:0.2s;" title="{{ __('messages.edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.hostels.destroy', $hostel) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('messages.confirm_delete_hostel') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding:4px 10px; background:#EF4444; color:#fff; border:none; border-radius:6px; font-size:0.7rem; font-weight:600; cursor:pointer; transition:0.2s;" title="{{ __('messages.delete') }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    {{-- ✅ colspan 10 (पहिले 9 थियो, अब 10 भयो) --}}
                    <td colspan="10" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                        <i class="fas fa-hotel" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                        {{ __('messages.no_hostels_found') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ===== BULK ACTIONS ===== --}}
        @if($hostels->count() > 0)
        <div style="padding:12px 16px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; flex-wrap:wrap; align-items:center; gap:12px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-weight:600; color:#475569; font-size:0.85rem;">{{ __('messages.selected') }}:</span>
                <select name="bulk_action" id="bulkAction" style="padding:8px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.85rem; background:#fff; cursor:pointer;">
                    <option value="">{{ __('messages.choose_action') }}</option>
                    <option value="approve">{{ __('messages.bulk_approve') }}</option>
                    <option value="reject">{{ __('messages.bulk_reject') }}</option>
                    <option value="feature">{{ __('messages.bulk_feature') }}</option>
                    <option value="unfeature">{{ __('messages.bulk_unfeature') }}</option>
                    <option value="hide">{{ __('messages.bulk_hide') }}</option>
                    <option value="show">{{ __('messages.bulk_show') }}</option>
                    <option value="delete">{{ __('messages.bulk_delete') }}</option>
                </select>
                <button type="submit" style="background:#0EA5E9; color:#fff; border:none; padding:8px 20px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.2s; box-shadow:0 2px 10px rgba(14,165,233,0.2);">
                    <i class="fas fa-check"></i> {{ __('messages.apply') }}
                </button>
            </div>
            <div style="margin-left:auto; font-size:0.8rem; color:#94a3b8;">
                <span id="selectedCount">0</span> {{ __('messages.items_selected') }}
            </div>
        </div>
        @endif
    </form>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:center;">
    {{ $hostels->appends(request()->query())->links() }}
</div>

@endsection

@push('styles')
<style>
    /* Table row hover effect */
    tbody tr:hover {
        background: #f8fafc;
    }

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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== SELECT ALL =====
        const selectAll = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
        const selectedCount = document.getElementById('selectedCount');

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.rowCheckbox:checked').length;
            if (selectedCount) selectedCount.textContent = checked;
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                updateSelectedCount();
                if (!this.checked && selectAll) {
                    selectAll.checked = false;
                }
                if (selectAll) {
                    const allChecked = Array.from(rowCheckboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                }
            });
        });

        updateSelectedCount();
    });

    // ✅ बल्क एक्शन कन्फर्मेसन
    function confirmBulkAction() {
        const action = document.getElementById('bulkAction').value;
        const checked = document.querySelectorAll('.rowCheckbox:checked');
        
        if (checked.length === 0) {
            alert('{{ __('messages.select_at_least_one') }}');
            return false;
        }
        if (action === '') {
            alert('{{ __('messages.choose_action_first') }}');
            return false;
        }
        if (action === 'delete') {
            return confirm('{{ __('messages.confirm_bulk_delete') }}');
        } else {
            let confirmMsg = '{{ __('messages.confirm_bulk_action') }}'.replace(':action', action);
            return confirm(confirmMsg);
        }
    }

    // ✅ Advanced Filters Toggle
    function toggleAdvancedFilters() {
        var el = document.getElementById('advancedFilters');
        if (el.style.display === 'none' || el.style.display === '') {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    }
</script>
@endpush