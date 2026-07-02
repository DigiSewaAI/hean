<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    // ============================================================
    // STATUS CONSTANTS
    // ============================================================
    const STATUS_PENDING  = 'pending';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REFUNDED = 'refunded';

    // ============================================================
    // FILLABLE ATTRIBUTES
    // ============================================================
    protected $fillable = [
        'registration_id',
        'invoice_id',           // नयाँ थपियो
        'method',               // bank, esewa, khalti, cash
        'transaction_id',
        'amount',
        'payment_date',
        'bank_name',
        'bank_account',
        'screenshot_path',
        'status',               // pending, verified, rejected, refunded
        'remarks',

        // नयाँ फिल्डहरू (audit)
        'verified_at',
        'verified_by',
        'refunded_at',
        'refunded_by',
        'refund_reason',
    ];

    // ============================================================
    // CASTS
    // ============================================================
    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
        // नयाँ casts
        'verified_at'  => 'datetime',
        'refunded_at'  => 'datetime',
    ];

    // ============================================================
    // RELATIONSHIPS
    // ============================================================
    /**
     * Get the registration that owns the payment.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the invoice that owns the payment.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the receipts for this payment.
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    // ============================================================
    // STATUS HELPER METHODS
    // ============================================================

    /**
     * Mark this payment as verified.
     *
     * @param int $userId
     * @throws \Exception
     */
    public function markVerified(int $userId): void
    {
        if ($this->status === self::STATUS_VERIFIED) {
            throw new \Exception('Payment already verified.');
        }

        $this->status = self::STATUS_VERIFIED;
        $this->verified_at = now();
        $this->verified_by = $userId;
        $this->save();
    }

    /**
     * Mark this payment as refunded.
     *
     * @param int $userId
     * @param string|null $reason
     * @throws \Exception
     */
    public function markRefunded(int $userId, ?string $reason = null): void
    {
        if ($this->status !== self::STATUS_VERIFIED) {
            throw new \Exception('Only verified payments can be refunded.');
        }

        $this->status = self::STATUS_REFUNDED;
        $this->refunded_at = now();
        $this->refunded_by = $userId;
        $this->refund_reason = $reason;
        $this->save();
    }

    // ============================================================
    // VALIDATION METHOD (Service मा प्रयोग गर्न)
    // ============================================================

    /**
     * Validate that the payment's registration matches the invoice's registration.
     *
     * @param int $invoiceId
     * @param int $registrationId
     * @return bool
     */
    public static function validateInvoiceRegistration(int $invoiceId, int $registrationId): bool
    {
        $invoice = Invoice::find($invoiceId);
        if (!$invoice) {
            return false;
        }
        return $invoice->registration_id === $registrationId;
    }

    // ============================================================
    // SCOPES (वैकल्पिक)
    // ============================================================
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', self::STATUS_VERIFIED);
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', self::STATUS_REFUNDED);
    }
}