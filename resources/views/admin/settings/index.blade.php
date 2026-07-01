@extends('layouts.admin')

@section('title', __('messages.admin_settings_title') . ' - HEAN Admin')

@section('content')
<h2>{{ __('messages.admin_settings_title') }}</h2>
<form action="{{ route('admin.settings.update') }}" method="POST" class="dashboard-form">
    @csrf
    <div class="form-group"><label>{{ __('messages.site_name') }}</label><input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"></div>
    <div class="form-group"><label>{{ __('messages.address') }}</label><input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}"></div>
    <div class="form-group"><label>{{ __('messages.phone') }}</label><input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}"></div>
    <div class="form-group"><label>{{ __('messages.email') }}</label><input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}"></div>
    <div class="form-group"><label>{{ __('messages.office_hours') }}</label><input type="text" name="office_hours" value="{{ $settings['office_hours'] ?? '' }}"></div>
    <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
</form>
@endsection