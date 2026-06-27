@extends('layouts.admin')

@section('title', 'समिति - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>समिति सदस्यहरू</h2>
    <a href="{{ route('admin.committee.create') }}" class="btn btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; transition:0.3s;">
        <i class="fas fa-plus"></i> नयाँ थप्नुहोस्
    </a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>नाम</th>
                <th>पद</th>
                <th>प्रकाशित</th>
                <th>क्रम</th>
                <th>कार्य</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td>{{ $member->id }}</td>
                <td>
                    @if($member->image)
                        <img src="{{ asset('storage/'.$member->image) }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover; margin-right:8px;">
                    @endif
                    {{ $member->name }}
                </td>
                <td>{{ $member->position }}</td>
                <td>
                    <span style="color:{{ $member->is_published ? '#10B981' : '#dc2626' }};">
                        {{ $member->is_published ? '✅' : '❌' }}
                    </span>
                </td>
                <td>{{ $member->order ?? 0 }}</td>
                <td>
                    <a href="{{ route('admin.committee.edit', $member) }}" class="btn-action btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:4px 12px; border-radius:6px; text-decoration:none; font-size:0.75rem; display:inline-block;">सम्पादन</a>
                    <form action="{{ route('admin.committee.destroy', $member) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-danger-sm" style="background:#ef4444; color:#fff; padding:4px 12px; border-radius:6px; border:none; font-size:0.75rem; cursor:pointer;" onclick="return confirm('के तपाईं यो सदस्य मेट्न चाहनुहुन्छ?')">मेट्नुहोस्</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">कुनै सदस्य छैन।</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $members->links() }}
</div>
@endsection