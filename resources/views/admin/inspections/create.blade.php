@extends('layouts.admin')

@section('title', 'निरीक्षण - HEAN Admin')

@section('content')
<h2>निरीक्षण फारम</h2>
<p><strong>होस्टेल:</strong> {{ $registration->hostel_name }}</p>
<p><strong>सञ्चालक:</strong> {{ $registration->operator_name }}</p>

<form action="{{ route('admin.inspections.store') }}" method="POST">
    @csrf
    <input type="hidden" name="registration_id" value="{{ $registration->id }}">
    <table class="checklist-table">
        <thead><tr><th>क्र.सं.</th><th>निरीक्षण बुँदा</th><th>स्थिति</th><th>टिप्पणी</th></tr></thead>
        <tbody>
            <tr><td>1</td><td>कोठाको अवस्था</td><td><input type="checkbox" name="checklist[room_condition]" value="pass"></td><td><input type="text" name="remarks[room_condition]"></td></tr>
            <tr><td>2</td><td>सरसफाइ</td><td><input type="checkbox" name="checklist[hygiene]" value="pass"></td><td><input type="text" name="remarks[hygiene]"></td></tr>
            <tr><td>3</td><td>सुरक्षा</td><td><input type="checkbox" name="checklist[safety]" value="pass"></td><td><input type="text" name="remarks[safety]"></td></tr>
        </tbody>
    </table>
    <div class="form-group"><label>समग्र टिप्पणी</label><textarea name="remarks"></textarea></div>
    <button type="submit" class="btn btn-primary">पेश गर्नुहोस्</button>
</form>
@endsection