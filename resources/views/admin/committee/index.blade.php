@extends('layouts.admin')

@section('title', __('messages.admin_committee_title') . ' - HEAN Admin')

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#8B5CF6; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-users" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $totalMembers ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_members') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#22C55E; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-check-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $publishedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.published') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#94a3b8; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-eye-slash" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $unpublishedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.unpublished') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS + ACTIONS ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.committee.index') }}" method="GET" id="filterForm">
        {{-- Basic Search & Quick Filters --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#8B5CF6;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_committee_placeholder') }}" 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Published Status --}}
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.status') }}</label>
                <select name="published" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="published" {{ request('published')=='published'?'selected':'' }}>{{ __('messages.published') }}</option>
                    <option value="unpublished" {{ request('published')=='unpublished'?'selected':'' }}>{{ __('messages.unpublished') }}</option>
                </select>
            </div>

            {{-- Filter: Position (Dynamic Dropdown) --}}
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.position') }}</label>
                <select name="position" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position')==$pos?'selected':'' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sort --}}
            <div style="flex:1; min-width:130px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.sort_by') }}</label>
                <select name="sort" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="order_asc" {{ request('sort')=='order_asc'?'selected':'' }}>{{ __('messages.sort_order_asc') }}</option>
                    <option value="order_desc" {{ request('sort')=='order_desc'?'selected':'' }}>{{ __('messages.sort_order_desc') }}</option>
                    <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>{{ __('messages.sort_name_asc') }}</option>
                    <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>{{ __('messages.sort_name_desc') }}</option>
                    <option value="position_asc" {{ request('sort')=='position_asc'?'selected':'' }}>{{ __('messages.sort_position_asc') }}</option>
                    <option value="position_desc" {{ request('sort')=='position_desc'?'selected':'' }}>{{ __('messages.sort_position_desc') }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <button type="submit" style="background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(139,92,246,0.25);">
                    <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                </button>
                <a href="{{ route('admin.committee.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-undo"></i> {{ __('messages.reset') }}
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ===== ADD NEW MEMBER BUTTON ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
    <div style="font-size:0.9rem; color:#64748b;">
        <i class="fas fa-info-circle"></i> 
        {{ __('messages.showing_members', ['total' => $members->total(), 'from' => $members->firstItem() ?? 0, 'to' => $members->lastItem() ?? 0]) }}
    </div>
    <a href="{{ route('admin.committee.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#8B5CF6; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(139,92,246,0.3);">
        <i class="fas fa-plus-circle"></i> {{ __('messages.add_new_member') }}
    </a>
</div>

{{-- ===== TABLE ===== --}}
<div style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.image') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.name') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.position') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.published') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.order') }}</th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                <td style="padding:12px 16px;">
                    @if($member->image)
                        <img src="{{ asset('storage/'.$member->image) }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0;">
                    @else
                        <div style="width:40px; height:40px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:0.7rem;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </td>
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">{{ $member->name }}</td>
                <td style="padding:12px 16px;">
                    <span style="background:#f3e8ff; color:#7c3aed; padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                        {{ $member->position }}
                    </span>
                </td>
                <td style="padding:12px 16px;">
                    @if($member->is_published)
                        <span style="background:#dcfce7; color:#166534; padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                            <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> {{ __('messages.yes') }}
                        </span>
                    @else
                        <span style="background:#fee2e2; color:#991b1b; padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                            <i class="fas fa-times-circle" style="font-size:0.65rem;"></i> {{ __('messages.no') }}
                        </span>
                    @endif
                </td>
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;">{{ $member->order ?? 0 }}</td>
                <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                    <a href="{{ route('admin.committee.edit', $member) }}" style="display:inline-block; padding:6px 14px; background:#F59E0B; color:#fff; border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600; transition:0.2s;">
                        <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                    </a>
                    <form action="{{ route('admin.committee.destroy', $member) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding:6px 14px; background:#EF4444; color:#fff; border:none; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer; transition:0.2s;" onclick="return confirm('{{ __('messages.confirm_delete_member') }}')">
                            <i class="fas fa-trash-alt"></i> {{ __('messages.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-users" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    {{ __('messages.no_members_found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:center;">
    {{ $members->appends(request()->query())->links() }}
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
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        border-color: #8B5CF6;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush