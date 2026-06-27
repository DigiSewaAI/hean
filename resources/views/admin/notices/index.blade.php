@extends('layouts.admin')

@section('title', 'सूचनाहरू - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">सूचनाहरू</h2>
    <a href="{{ route('admin.notices.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> नयाँ थप्नुहोस्
    </a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>शीर्षक</th>
                <th>मिति</th>
                <th>श्रेणी</th>
                <th>प्रकाशित</th>
                <th>कार्य</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notices as $notice)
            <tr>
                <td>{{ $notice->title }}</td>
                <td>{{ $notice->date }}</td>
                <td><span style="background:rgba(14,165,233,0.1); color:#0EA5E9; padding:2px 12px; border-radius:50px; font-size:0.7rem;">{{ $notice->category ?? 'General' }}</span></td>
                <td style="color:{{ $notice->is_published ? '#10B981' : '#dc2626' }};">{{ $notice->is_published ? '✅' : '❌' }}</td>
                <td>
                    <a href="{{ route('admin.notices.edit', $notice) }}" class="btn-action btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:6px 14px; border-radius:6px; text-decoration:none; font-size:0.75rem; display:inline-block; transition:0.2s;">सम्पादन</a>
                    <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-action btn-danger-sm" style="background:#ef4444; color:#fff; padding:6px 14px; border-radius:6px; border:none; font-size:0.75rem; cursor:pointer; transition:0.2s;" onclick="return confirm('के तपाईं यो सूचना मेट्न चाहनुहुन्छ?')">मेट्नुहोस्</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; padding:40px; color:#94a3b8;">कुनै सूचना छैन।</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $notices->links() }}
</div>
@endsection