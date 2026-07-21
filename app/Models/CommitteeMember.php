<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    protected $fillable = [
        'name',
        'position',
        'image',
        'facebook',
        'is_published',
        'order'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
    ];
}