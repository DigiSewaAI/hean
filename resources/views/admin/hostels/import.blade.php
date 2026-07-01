@extends('layouts.admin')

@section('title', __('messages.bulk_hostel_import') . ' - HEAN Admin')

@section('content')
<div style="max-width:600px; margin:0 auto;">
    <h2><i class="fas fa-upload"></i> {{ __('messages.bulk_hostel_import') }}</h2>
    <p style="color:#64748b;">{{ __('messages.upload_csv_hostel_data') }}</p>

    <form action="{{ route('admin.hostels.bulk.store') }}" method="POST" enctype="multipart/form-data" style="background:#fff; padding:24px; border-radius:12px; border:1px solid #e2e8f0;">
        @csrf
        <div style="margin-bottom:16px;">
            <label style="font-weight:600;">{{ __('messages.choose_csv_file') }}</label>
            <input type="file" name="file" accept=".csv,.txt" required style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:6px;">
        </div>
        <button type="submit" style="background:#8B5CF6; color:#fff; padding:10px 24px; border:none; border-radius:50px; font-weight:600; cursor:pointer;">
            <i class="fas fa-upload"></i> {{ __('messages.bulk_import') }}
        </button>
        <a href="{{ route('admin.hostels.index') }}" style="margin-left:12px; color:#64748b;">{{ __('messages.cancel') }}</a>
    </form>

    <div style="margin-top:24px; background:#f8fafc; padding:16px; border-radius:8px;">
        <h5>{{ __('messages.csv_format_example') }}</h5>
        <pre style="background:#1e293b; color:#e2e8f0; padding:12px; border-radius:6px; overflow-x:auto;">
hostel_name,district,municipality,ward,contact,email,capacity
"Sunshine Hostel","Kathmandu","Kathmandu","4","9841234567","info@sunshine.com","50"
"Green Valley","Lalitpur","Lalitpur","2","9841234568","green@valley.com","40"
        </pre>
    </div>
</div>
@endsection