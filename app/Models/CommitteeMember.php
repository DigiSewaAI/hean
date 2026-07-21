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
        'is_published',
        'order',
        'committee_type_id',
        'district_id',
        // अन्य optional fields (यदि प्रयोग गर्नुहुन्छ भने)
        'phone',
        'email',
        'photo_alt',
        'website',
        'twitter',
        'instagram',
        'youtube',
        'biography',
        'is_featured',
        'slug',
        'term_start',
        'term_end',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
        'is_featured' => 'boolean',
        'term_start' => 'date',
        'term_end' => 'date',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::disk('cloud')->url($this->image);
        }
        return asset('images/avatar-placeholder.png');
    }
}