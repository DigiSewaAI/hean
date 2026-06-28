<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',      // ✅ Add this – essential foreign key
        'method',               // bank, esewa, khalti
        'transaction_id',
        'amount',
        'payment_date',
        'bank_name',
        'bank_account',
        'screenshot_path',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}