@extends('layouts.admin')

@section('title', __('messages.edit_hostel') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-edit me-2" style="color:#0EA5E9;"></i> {{ __('messages.edit_hostel') }}
    </h2>
    <a href="{{ route('admin.hostels.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.hostels.update', $hostel) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ===== Error Messages ===== --}}
        @if($errors->any())
            <div style="background:#fef2f2; border-left:4px solid #dc2626; padding:12px 20px; border-radius:8px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:20px; color:#dc2626;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ===== Row 1: Name (Nepali + English) ===== --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-group">
                <label for="name_nepali" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.hostel_name_nepali') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="name_nepali" id="name_nepali" value="{{ old('name_nepali', $hostel->name_nepali) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.2s;" required>
                @error('name_nepali') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="name_english" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.hostel_name_english') }} <span style="color:#64748b; font-weight:400;">({{ __('messages.optional') }})</span>
                </label>
                <input type="text" name="name_english" id="name_english" value="{{ old('name_english', $hostel->name_english) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.2s;">
                @error('name_english') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ===== Row 2: Type + Capacity + Rooms ===== --}}
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-group">
                <label for="type" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.type') }} <span style="color:#dc2626;">*</span>
                </label>
                <select name="type" id="type" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;" required>
                    <option value="">{{ __('messages.select_type') }}</option>
                    <option value="boys" {{ old('type', $hostel->type) == 'boys' ? 'selected' : '' }}>{{ __('messages.boys') }}</option>
                    <option value="girls" {{ old('type', $hostel->type) == 'girls' ? 'selected' : '' }}>{{ __('messages.girls') }}</option>
                    <option value="co-ed" {{ old('type', $hostel->type) == 'co-ed' ? 'selected' : '' }}>{{ __('messages.co_ed') }}</option>
                </select>
                @error('type') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="capacity" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.total_beds') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $hostel->capacity) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" min="0" required>
                @error('capacity') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="rooms" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.total_rooms') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="number" name="rooms" id="rooms" value="{{ old('rooms', $hostel->rooms) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" min="0" required>
                @error('rooms') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ===== Row 3: Operator + Contact ===== --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-group">
                <label for="operator_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.operator_name') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="operator_name" id="operator_name" value="{{ old('operator_name', $hostel->operator_name) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" required>
                @error('operator_name') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="contact" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.contact') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="contact" id="contact" value="{{ old('contact', $hostel->contact) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" required>
                @error('contact') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ===== Row 4: District + Municipality + Ward ===== --}}
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-group">
                <label for="district" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.district') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="district" id="district" value="{{ old('district', $hostel->district) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" required>
                @error('district') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="municipality" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.municipality') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="municipality" id="municipality" value="{{ old('municipality', $hostel->municipality) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" required>
                @error('municipality') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="ward" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.ward') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="ward" id="ward" value="{{ old('ward', $hostel->ward) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" required>
                @error('ward') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ===== Row 5: Street ===== --}}
        <div style="margin-bottom:16px;">
            <div class="form-group">
                <label for="street" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.street') }} <span style="color:#64748b; font-weight:400;">({{ __('messages.optional') }})</span>
                </label>
                <input type="text" name="street" id="street" value="{{ old('street', $hostel->street) }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                @error('street') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Row: Local Registration Number --}}
<div style="margin-bottom:16px;">
    <div class="form-group">
        <label for="local_registration_number" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            {{ __('messages.local_registration_number') }} <span style="color:#dc2626;">*</span>
        </label>
        <input type="text" name="local_registration_number" id="local_registration_number"
               value="{{ old('local_registration_number', $hostel->local_registration_number) }}"
               placeholder="{{ __('messages.placeholder_local_registration_number') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               required>
        @error('local_registration_number')
            <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
        @enderror
        <small style="color:#64748b; font-size:0.75rem;">
            <i class="fas fa-info-circle"></i>
            {{ __('messages.help_local_registration_number') }}
        </small>
    </div>
</div>

        {{-- ===== Row 6: Description ===== --}}
        <div style="margin-bottom:16px;">
            <div class="form-group">
                <label for="description" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.description') }} <span style="color:#64748b; font-weight:400;">({{ __('messages.optional') }})</span>
                </label>
                <textarea name="description" id="description" rows="3"
                          style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">{{ old('description', $hostel->description) }}</textarea>
                @error('description') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ===== Row 7: Image Upload ===== --}}
        <div style="margin-bottom:16px;">
            <div class="form-group">
                <label for="image" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                    {{ __('messages.image') }} <span style="color:#64748b; font-weight:400;">({{ __('messages.optional') }})</span>
                </label>
                @if($hostel->image)
                    <div style="margin-bottom:8px;">
                        <img src="{{ asset('storage/'.$hostel->image) }}" alt="{{ $hostel->name_nepali }}" style="max-width:150px; border-radius:8px; border:1px solid #e2e8f0;">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.webp"
                       style="width:100%; padding:10px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                <small style="color:#64748b; font-size:0.75rem; display:block; margin-top:4px;">
                    <i class="fas fa-info-circle"></i> 
                    {{ __('messages.edit_allowed_formats_hostel') }}
                </small>
                @error('image') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ===== Row 8: Checkboxes (Approved, Featured, Visible) ===== --}}
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:24px;">
            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="approved" id="approved" value="1" {{ old('approved', $hostel->approved) ? 'checked' : '' }}
                       style="width:18px; height:18px; accent-color:#0EA5E9; cursor:pointer;">
                <label for="approved" style="font-weight:600; color:#1e293b; cursor:pointer;">
                    <i class="fas fa-check-circle" style="color:#22C55E;"></i> {{ __('messages.approved') }}
                </label>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $hostel->featured) ? 'checked' : '' }}
                       style="width:18px; height:18px; accent-color:#0EA5E9; cursor:pointer;">
                <label for="featured" style="font-weight:600; color:#1e293b; cursor:pointer;">
                    <i class="fas fa-star" style="color:#F59E0B;"></i> {{ __('messages.featured') }}
                </label>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="visible" id="visible" value="1" {{ old('visible', $hostel->visible) ? 'checked' : '' }}
                       style="width:18px; height:18px; accent-color:#0EA5E9; cursor:pointer;">
                <label for="visible" style="font-weight:600; color:#1e293b; cursor:pointer;">
                    <i class="fas fa-eye" style="color:#0EA5E9;"></i> {{ __('messages.visible') }}
                </label>
            </div>
        </div>

        {{-- ===== Submit Buttons ===== --}}
        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> {{ __('messages.update') }}
            </button>
            <a href="{{ route('admin.hostels.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                {{ __('messages.cancel') }}
            </a>
        </div>

    </form>
</div>
@endsection