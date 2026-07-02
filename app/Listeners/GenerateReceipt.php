<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Services\PaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateReceipt implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PaymentVerified $event)
    {
        // Service ले Receipt generate गर्छ
        $paymentService = app(PaymentService::class);
        $paymentService->generateReceipt($event->payment);
    }
}