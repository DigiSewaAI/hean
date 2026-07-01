@extends('layouts.admin')

@section('title', __('messages.duplicate_review_title'))

@section('content')
<div class="container-fluid py-4">
    <h1>{{ __('messages.duplicate_review_title') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('messages.registration') }}</th>
                        <th>{{ __('messages.hostel') }}</th>
                        <th>{{ __('messages.owner') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td>#{{ $reg->id }}</td>
                        <td>{{ $reg->hostel->name ?? __('messages.not_available') }}</td>
                        <td>{{ $reg->owner->name ?? __('messages.not_available') }}</td>
                        <td>
                            @if($reg->duplicateReviews()->exists())
                                <span class="badge bg-success">{{ __('messages.reviewed') }}</span>
                            @else
                                <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.duplicate.review', $reg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="is_duplicate" value="0">
                                <button class="btn btn-sm btn-success">{{ __('messages.not_duplicate') }}</button>
                            </form>
                            <form action="{{ route('admin.duplicate.review', $reg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="is_duplicate" value="1">
                                <button class="btn btn-sm btn-danger">{{ __('messages.duplicate') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">{{ __('messages.no_pending_duplicate_review') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $registrations->links() }}
        </div>
    </div>
</div>
@endsection