@extends('layouts.admin')

@section('title', 'आवेदनहरू - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">आवेदनहरू</h2>
    <a href="{{ route('admin.registrations.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> नयाँ दर्ता
    </a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>होस्टेल</th>
                <th>जिल्ला</th>
                <th>स्थिति</th>
                <th>कार्य</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
            <tr>
                <td>{{ $reg->id }}</td>
                <td>{{ $reg->hostel_name }}</td>
                <td>{{ $reg->district }}</td>
                <td>
                    <span class="badge-status badge-{{ $reg->status }}">
                        {{ ucfirst($reg->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.registrations.show', $reg) }}" class="btn-action btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:6px 14px; border-radius:6px; text-decoration:none; font-size:0.75rem; display:inline-block; transition:0.2s;">विवरण</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; padding:40px; color:#94a3b8;">कुनै आवेदन छैन।</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $registrations->links() }}
</div>
@endsection