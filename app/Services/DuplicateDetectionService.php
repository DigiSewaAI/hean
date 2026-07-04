<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\DuplicateReview;

class DuplicateDetectionService
{
    /**
     * Check if a registration is a duplicate.
     * ✅ अब डुप्लिकेट जाँच Hostel::checkDuplicate() बाट गरिन्छ, यसैले यो method ले false मात्र फर्काउँछ।
     */
    public function check(Registration $registration): bool
    {
        // अब डुप्लिकेट जाँच कन्ट्रोलरमा Hostel::checkDuplicate() प्रयोग गरी गरिन्छ।
        // यस सेवा मार्फत कुनै पनि जाँच गरिंदैन।
        return false;
    }

    /**
     * Mark a registration as reviewed for duplicate.
     */
    public function markReviewed(Registration $registration, $isDuplicate, $notes = null)
    {
        return DuplicateReview::create([
            'registration_id' => $registration->id,
            'reviewed_by' => auth()->id(),
            'is_duplicate' => $isDuplicate,
            'notes' => $notes,
            'reviewed_at' => now(),
        ]);
    }
}