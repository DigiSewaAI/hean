@extends('layouts.admin')

@section('title', __('messages.import_title'))

@section('content')
<div class="container-fluid py-4">
    <h1>{{ __('messages.import_title') }}</h1>

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                {{ __('messages.import_placeholder') }}
            </div>

            <form action="{{ route('admin.import.prepare') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Upload CSV/Excel file</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".csv,.xlsx,.xls">
                </div>
                <button type="submit" class="btn btn-primary">Prepare Import</button>
            </form>
        </div>
    </div>
</div>
@endsection