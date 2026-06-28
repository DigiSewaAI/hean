<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    protected $fillable = [
        // Foreign keys & meta
        'owner_id',
        'hostel_id',
        'source',
        'submitted_at',
        'approved_at',
        'status',
        'pan',
        'registration_number',
        'inspector_id',

        // Registration form data (all columns after migration)
        'hostel_name',
        'operator_name',
        'hostel_type',
        'capacity',
        'established_year',
        'contact',
        'email',
        'website',
        'description',
        'province',
        'district',
        'municipality',
        'ward',
        'street',
        'landmark',

        // Optional JSON field (if you still use it)
        'documents',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'capacity' => 'integer',
        'established_year' => 'integer',
        'documents' => 'array',  // if you keep this field
    ];

    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function duplicateReviews(): HasMany
    {
        return $this->hasMany(DuplicateReview::class);
    }

    // ============================================================
    // SCOPES
    // ============================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}