<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Registration extends Model
{
    // ============================================================
    // STATUS CONSTANTS
    // ============================================================
    const STATUS_PENDING          = 'pending';
    const STATUS_APPROVED         = 'approved';
    const STATUS_AWAITING_PAYMENT = 'awaiting_payment';
    const STATUS_ACTIVE           = 'active';
    const STATUS_EXPIRED          = 'expired';
    const STATUS_REJECTED         = 'rejected';
    const STATUS_DUPLICATE        = 'duplicate';

    // ============================================================
    // FILLABLE ATTRIBUTES
    // ============================================================
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

        // नयाँ फिल्डहरू (validity dates)
        'valid_from',
        'valid_until',
        'block_name',
        'local_registration_number',
        'fee',


    ];

    // ============================================================
    // CASTS
    // ============================================================
    protected $casts = [
        'submitted_at'   => 'datetime',
        'approved_at'    => 'datetime',
        'capacity'       => 'integer',
        'rooms'          => 'integer',
        'established_year' => 'integer',
        'documents'      => 'array',
        'valid_from'     => 'date',
        'valid_until'    => 'date',
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

    public function uploadedDocuments(): HasMany
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
     * ✅ FIXED: Get receipts via payments (hasManyThrough)
     * Since receipts table no longer has registration_id,
     * we go through the payments table.
     */
    public function receipts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Receipt::class,        // Final model
            Payment::class,        // Intermediate model
            'registration_id',     // Foreign key on payments table
            'payment_id',          // Foreign key on receipts table
            'id',                  // Local key on registrations
            'id'                   // Local key on payments
        );
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

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                     ->where('valid_until', '>=', today());
    }

    // ============================================================
    // FINANCIAL SUMMARY ACCESSORS
    // ============================================================
    public function getTotalInvoicedAttribute(): float
    {
        return $this->invoices()->sum('amount') ?? 0;
    }

    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->where('status', 'verified')->sum('amount') ?? 0;
    }

    public function getOutstandingAttribute(): float
    {
        return max(0, $this->total_invoiced - $this->total_paid);
    }

    /**
     * ✅ FIXED: Get latest receipt via new relationship
     */
    public function getLatestReceiptAttribute()
    {
        return $this->receipts()->latest()->first();
    }

    // ============================================================
    // VALIDITY & STATUS HELPER METHODS
    // ============================================================
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE &&
               $this->valid_until &&
               $this->valid_until->isFuture();
    }

    public function activate(): void
    {
        $this->status = self::STATUS_ACTIVE;
        $this->valid_from = today();
        $this->valid_until = today()->addYear();
        $this->save();
    }

    public function markAwaitingPayment(): void
    {
        if ($this->status === self::STATUS_APPROVED) {
            $this->status = self::STATUS_AWAITING_PAYMENT;
            $this->save();
        }
    }
}