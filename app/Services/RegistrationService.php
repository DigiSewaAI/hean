<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrationService
{
    /**
     * कुनै पनि सक्रिय दर्ता छ कि जाँच गर्ने (PAN/email/contact)
     */
    public function checkDuplicate($pan, $email, $contact): ?Registration
    {
        return Registration::where('status', '!=', 'rejected')
            ->where('status', '!=', 'duplicate')
            ->where(function ($query) use ($pan, $email, $contact) {
                $query->where('pan', $pan)
                      ->orWhere('email', $email)
                      ->orWhere('contact', $contact);
            })
            ->where(function ($q) {
                $q->where('status', 'active')
                  ->orWhere('status', 'awaiting_payment')
                  ->orWhere('valid_until', '>=', today());
            })
            ->first();
    }

    /**
     * इन्भ्वाइस पूर्ण भुक्तान भएपछि यो कल गर्ने
     */
    public function activateFromInvoice(Invoice $invoice): void
    {
        $registration = $invoice->registration;
        if ($registration->status === Registration::STATUS_ACTIVE) {
            return; // पहिले नै active
        }

        DB::transaction(function () use ($registration, $invoice) {
            // इन्भ्वाइसको स्टेटस अपडेट गर्ने (PaymentService ले गर्छ)
            $registration->activate();
            Log::info("Registration {$registration->id} activated after full payment of invoice {$invoice->id}");
        });
    }

    /**
     * रजिस्ट्रेशनलाई awaiting_payment मा सेट गर्ने (इन्भ्वाइस जेनरेट भएपछि)
     */
    public function markAwaitingPayment(Registration $registration): void
    {
        if ($registration->status === Registration::STATUS_APPROVED) {
            $registration->markAwaitingPayment();
        }
    }
}