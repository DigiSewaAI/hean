<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Receipt extends Model
{
    // ============================================================
    // FILLABLE ATTRIBUTES
    // ============================================================
    protected $fillable = [
        'payment_id',
        'receipt_number',
        'amount',
        'issued_date',
        'pdf_path',
        'remarks',
        // 'registration_id' र 'invoice_id' fillable बाट हटाइयो
        // (पुरानो डाटाको लागि relationships मात्र राखिएको छ)
    ];

    // ============================================================
    // CASTS
    // ============================================================
    protected $casts = [
        'issued_date' => 'date',
        'amount'      => 'decimal:2',
    ];

    // ============================================================
    // RELATIONSHIPS (पुरानो डाटाको लागि)
    // ============================================================
    /**
     * Get the registration (DEPRECATED: use getRegistration() instead).
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the payment that owns this receipt.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the invoice (DEPRECATED: use getInvoice() instead).
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    /**
     * Get the registration via payment relationship.
     * This is the preferred way to get registration from receipt.
     */
    public function getRegistration(): ?Registration
    {
        if ($this->payment && $this->payment->registration) {
            return $this->payment->registration;
        }

        // Fallback: if payment is missing but old registration_id exists
        if ($this->registration_id) {
            return Registration::find($this->registration_id);
        }

        return null;
    }

    /**
     * Get the invoice via payment relationship.
     * This is the preferred way to get invoice from receipt.
     */
    public function getInvoice(): ?Invoice
    {
        if ($this->payment && $this->payment->invoice) {
            return $this->payment->invoice;
        }

        // Fallback: if payment is missing but old invoice_id exists
        if ($this->invoice_id) {
            return Invoice::find($this->invoice_id);
        }

        return null;
    }

    /**
     * Generate a unique receipt number.
     */
    public static function generateReceiptNumber(): string
    {
        $prefix = 'RCPT-' . date('Y') . '-';
        $last = static::where('receipt_number', 'LIKE', $prefix . '%')
                      ->orderBy('id', 'desc')
                      ->first();

        if ($last) {
            $lastNumber = intval(substr($last->receipt_number, -5));
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . $newNumber;
    }

    // ============================================================
    // SCOPES
    // ============================================================
    public function scopeForPayment(Builder $query, int $paymentId): Builder
    {
        return $query->where('payment_id', $paymentId);
    }

    public function scopeIssuedBetween(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('issued_date', [$from, $to]);
    }
}