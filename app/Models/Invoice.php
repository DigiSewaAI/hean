<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_id',
        'invoice_number',
        'invoice_type',        // नयाँ थपियो
        'amount',
        'issued_date',
        'due_date',
        'status',              // payment status (pending, partial, paid, overdue)
        'pdf_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'issued_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the registration that owns the invoice.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the payments for this invoice.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the total paid amount for this invoice (only verified payments).
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->where('status', 'verified')->sum('amount') ?? 0;
    }

    /**
     * Get the outstanding amount for this invoice.
     */
    public function getOutstandingAttribute(): float
    {
        return max(0, $this->amount - $this->total_paid);
    }
    public function items(): HasMany
{
    return $this->hasMany(InvoiceItem::class)->orderBy('sort_order');
}

public function recalculateTotals(): void
{
    $this->loadMissing('items');
    $subtotal = $this->items->sum('amount');
    $this->subtotal = $subtotal;
    $this->amount = $subtotal - $this->discount + $this->tax;
    $this->saveQuietly();
}
}