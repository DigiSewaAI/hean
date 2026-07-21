<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class CommitteeMember extends Model
{
    protected $fillable = [
        'name',
        'position',
        'image',
        'facebook',
        'linkedin',
        'is_published',
        'order'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    public function getImageUrlAttribute()
{
    if ($this->image) {
        return Storage::disk('cloud')->url($this->image);
    }
    return asset('images/avatar-placeholder.png');
}

}