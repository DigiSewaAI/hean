<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Services\RegistrationService;
use App\Services\PaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ActivateRegistrationIfPaid

{
    public function handle(PaymentVerified $event)
    {
        Log::info('=== ActivateRegistrationIfPaid Listener Called ===');
        Log::info('Payment ID: ' . $event->payment->id);

        try {
            $payment = $event->payment;
            $invoice = $payment->invoice;

            if (!$invoice) {
                Log::warning('No invoice found for payment: ' . $payment->id);
                return;
            }

            $paymentService = app(PaymentService::class);
            $paymentService->updateInvoiceStatus($invoice);

            if ($invoice->status === 'paid') {
                app(RegistrationService::class)->activateFromInvoice($invoice);
                Log::info('Registration activated for invoice: ' . $invoice->id);
            } else {
                Log::info('Invoice not fully paid, status: ' . $invoice->status);
            }
        } catch (\Exception $e) {
            Log::error('ActivateRegistrationIfPaid failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}