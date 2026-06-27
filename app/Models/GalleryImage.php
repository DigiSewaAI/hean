<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'image',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}