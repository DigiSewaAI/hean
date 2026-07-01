<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'status',               // नयाँ थपियो (pending, verified, rejected, refunded)
        'remarks',              // नयाँ थपियो
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

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
}