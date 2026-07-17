<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Hostel;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RegistrationService
{
    /**
     * कुनै पनि सक्रिय दर्ता छ कि जाँच गर्ने (PAN/email/contact)
     * ⚠️ अब यो method deprecated छ – अब डुप्लिकेट जाँच Hostel::checkDuplicate() बाट गरिन्छ।
     * यदि यो method अरू ठाउँमा प्रयोग भइरहेको छ भने, कृपया त्यसलाई हटाउनुहोस् वा false फर्काउनुहोस्।
     */
    public function checkDuplicate($pan, $email, $contact): ?Registration
    {
        // ✅ अब PAN/email/contact मा आधारित duplicate जाँच गरिंदैन
        // किनभने एउटै PAN/email/contact मा धेरै होस्टल दर्ता गर्न सकिन्छ।
        // त्यसैले सधैं null फर्काउँछौं।
        return null;
    }

    /**
     * इन्भ्वाइस पूर्ण भुक्तान भएपछि यो कल गर्ने
     */
    public function activateFromInvoice(Invoice $invoice): void
    {
        $registration = $invoice->registration;
        if ($registration->status === Registration::STATUS_ACTIVE) {
            return;
        }

        DB::transaction(function () use ($registration, $invoice) {
            // ✅ Ensure hostel exists (with image)
            $this->ensureHostelExists($registration);

            $registration->activate();
            Log::info("Registration {$registration->id} activated after full payment of invoice {$invoice->id}");
        });
    }

    /**
     * Ensure a hostel exists for the registration.
     * Creates one if not exists, and copies the first image from documents.
     * ✅ refresh() र guard थपियो।
     */
    private function ensureHostelExists(Registration $registration)
    {
        if ($registration->hostel_id) {
            return; // Already has a hostel
        }

        // ✅ Copy image from documents (signboard or photos)
        $imagePath = null;
        $doc = $registration->uploadedDocuments()
    ->whereIn('type', ['signboard', 'photos'])
    ->first();

        if ($doc && Storage::disk('public')->exists($doc->file_path)) {
            $filename = uniqid() . '_' . basename($doc->file_path);
            $newPath = 'hostels/' . $filename;
            Storage::disk('public')->copy($doc->file_path, $newPath);
            $imagePath = $newPath;
        }

        // ✅ Create hostel with all registration data + image + block_name
        $hostel = Hostel::create([
            'name_nepali' => $registration->hostel_name,
            'name_english' => $registration->hostel_name_english,
            'operator_name' => $registration->operator_name,
            'contact' => $registration->contact,
            'description' => $registration->description,
            'province' => $registration->province,
            'district' => $registration->district,
            'municipality' => $registration->municipality,
            'ward' => $registration->ward,
            'street' => $registration->street,
            'landmark' => $registration->landmark,
            'type' => $registration->hostel_type,
            'capacity' => $registration->capacity,
            'rooms' => $registration->rooms,
            'established_year' => $registration->established_year,
            'email' => $registration->email,
            'website' => $registration->website,
            'block_name' => $registration->block_name ?? null,  // ✅ थपियो
            'image' => $imagePath,
            'approved' => true,
            'visible' => true,
            'featured' => false,
        ]);

        // ✅ ताजा मान ल्याउन refresh() – event बाट registration_number ल्याउँछ
        $hostel->refresh();

        $registration->hostel_id = $hostel->id;

        // ✅ Guard: यदि पहिले नै registration_number सेट छैन भने मात्र प्रतिलिपि गर्ने
        if (empty($registration->registration_number)) {
            $registration->registration_number = $hostel->registration_number;
        }

        $registration->save();
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