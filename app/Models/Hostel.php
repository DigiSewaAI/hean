<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'image',
        'owner_id',          // ✅ Added – foreign key to users table
    ];

    protected $casts = [
        'approved' => 'boolean',
        'visible' => 'boolean',
        'featured' => 'boolean',
    ];

    /**
     * Get the owner (user) of this hostel.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the registrations associated with this hostel.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope to show only approved and visible hostels.
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', true)->where('visible', true);
    }

    /**
     * Scope for featured hostels.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Convenience accessor for hostel name.
     */
    public function getNameAttribute()
    {
        return $this->name_nepali ?? $this->name_english ?? 'N/A';
    }
}