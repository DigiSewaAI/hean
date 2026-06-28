@extends('layouts.admin')

@section('title', 'Duplicate Review')

@section('content')
<div class="container-fluid py-4">
    <h1>Duplicate Review</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Registration</th>
                        <th>Hostel</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td>#{{ $reg->id }}</td>
                        <td>{{ $reg->hostel->name ?? 'N/A' }}</td>
                        <td>{{ $reg->owner->name ?? 'N/A' }}</td>
                        <td>{{ $reg->duplicateReviews()->exists() ? 'Reviewed' : 'Pending' }}</td>
                        <td>
                            <form action="{{ route('admin.duplicate.review', $reg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="is_duplicate" value="0">
                                <button class="btn btn-sm btn-success">Not Duplicate</button>
                            </form>
                            <form action="{{ route('admin.duplicate.review', $reg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="is_duplicate" value="1">
                                <button class="btn btn-sm btn-danger">Duplicate</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">No registrations pending duplicate review.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $registrations->links() }}
        </div>
    </div>
</div>
@endsection