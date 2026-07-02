<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Services\RegistrationService;
use App\Services\PaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateRegistrationIfPaid implements ShouldQueue
{
    public function handle(PaymentVerified $event)
    {
        $payment = $event->payment;
        $invoice = $payment->invoice;
        // Invoice status update गर्ने
        $paymentService = app(PaymentService::class);
        $paymentService->updateInvoiceStatus($invoice);

        // यदि paid भयो भने activate
        if ($invoice->status === 'paid') {
            app(RegistrationService::class)->activateFromInvoice($invoice);
        }
    }
}