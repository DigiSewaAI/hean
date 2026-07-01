<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\District;
use App\Models\Municipality;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function provinces()
    {
        return Province::orderBy('name')->get(['id', 'name']);
    }

    public function districts($provinceId)
    {
        return District::where('province_id', $provinceId)->orderBy('name')->get(['id', 'name']);
    }

    public function municipalities($districtId)
    {
        return Municipality::where('district_id', $districtId)->orderBy('name')->get(['id', 'name']);
    }
}