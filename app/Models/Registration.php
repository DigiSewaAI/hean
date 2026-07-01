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

        // Registration form data – सबै फिल्डहरू तालिका अनुसार
        'hostel_name',
        'hostel_name_english',
        'operator_name',
        'hostel_type',
        'capacity',
        'rooms',
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
        'documents',
    ];

    protected $casts = [
        'submitted_at'   => 'datetime',
        'approved_at'    => 'datetime',
        'capacity'       => 'integer',
        'rooms'          => 'integer',
        'established_year' => 'integer',
        'documents'      => 'array',
    ];

    // ============================================================
    // BOOT METHOD - नयाँ रजिस्ट्रेसनमा स्वतः नम्बर सेट गर्न
    // ============================================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            // यदि registration_number पहिले नै सेट छैन भने मात्र जेनरेट गर
            if (empty($registration->registration_number)) {
                // हालको अधिकतम ID + 1 लिएर नम्बर बनाउँछ
                $nextId = static::max('id') + 1;
                $registration->registration_number = 'REG-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

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

    /**
     * Get the receipts for this registration.
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
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

    // ============================================================
    // FINANCIAL SUMMARY ACCESSORS
    // ============================================================

    /**
     * Get the total invoiced amount for this registration.
     */
    public function getTotalInvoicedAttribute(): float
    {
        return $this->invoices()->sum('amount') ?? 0;
    }

    /**
     * Get the total paid amount for this registration (only verified payments).
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->where('status', 'verified')->sum('amount') ?? 0;
    }

    /**
     * Get the outstanding balance for this registration.
     */
    public function getOutstandingAttribute(): float
    {
        return max(0, $this->total_invoiced - $this->total_paid);
    }

    /**
     * Get the latest receipt for this registration.
     */
    public function getLatestReceiptAttribute()
    {
        return $this->receipts()->latest()->first();
    }
}