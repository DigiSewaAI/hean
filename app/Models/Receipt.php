<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'registration_id',
        'payment_id',
        'invoice_id',
        'receipt_number',
        'amount',
        'issued_date',
        'pdf_path',
        'remarks',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}