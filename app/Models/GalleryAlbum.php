<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'event_date' => 'date',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->name);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'album_id'); // ← महत्त्वपूर्ण
    }

    public function publishedImages()
    {
        return $this->images()->where('is_published', true);
    }

    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return Storage::disk('cloud')->url($this->cover_image);
        }
        $first = $this->publishedImages()->first();
        return $first ? Storage::disk('cloud')->url($first->image) : asset('images/placeholder.jpg');
    }

    public function getPhotoCountAttribute()
    {
        return $this->publishedImages()->count();
    }
}