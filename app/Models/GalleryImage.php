<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'image',
        'is_published',
        'album_id', // ← यो रहनुपर्छ
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function album()
    {
        return $this->belongsTo(GalleryAlbum::class, 'album_id'); // ← महत्त्वपूर्ण
    }
}