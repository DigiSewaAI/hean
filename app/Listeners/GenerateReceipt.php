<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;

class GenerateReceipt
{
    public function handle(PaymentVerified $event)
    {
        Log::info('=== GenerateReceipt Listener Called ===');
        Log::info('Payment ID: ' . $event->payment->id);

        try {
            $paymentService = app(PaymentService::class);
            $receipt = $paymentService->generateReceipt($event->payment);
            Log::info('Receipt generated: ' . $receipt->receipt_number);
        } catch (\Exception $e) {
            Log::error('GenerateReceipt failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}