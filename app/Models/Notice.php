<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'content',
        'date',
        'category',
        'image',
        'is_featured',
        'is_published'
    ];

    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];
}