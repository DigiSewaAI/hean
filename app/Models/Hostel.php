<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = [
        'name_nepali',
        'name_english',
        'operator_name',
        'district',
        'municipality',
        'ward',
        'street',
        'contact',
        'description',
        'approved',
        'featured',
        'visible',
        'image'
    ];

    protected $casts = [
        'approved' => 'boolean',
        'featured' => 'boolean',
        'visible' => 'boolean',
    ];
}