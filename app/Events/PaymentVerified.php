<?php

namespace App\Events;

use App\Models\Payment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentVerified
{
    use Dispatchable, SerializesModels;

    public Payment $payment;
    public int $verifiedByUserId;

    public function __construct(Payment $payment, int $verifiedByUserId)
    {
        $this->payment = $payment;
        $this->verifiedByUserId = $verifiedByUserId;
    }
}