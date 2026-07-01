<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\DuplicateReview;

class DuplicateDetectionService
{
    /**
     * Check if a registration is a duplicate based on hostel name, owner citizenship, or PAN.
     */
    public function check(Registration $registration): bool
    {
        // Check by hostel name (case insensitive)
        $duplicate = Registration::where('hostel_id', $registration->hostel_id)
            ->where('id', '!=', $registration->id)
            ->exists();

        if ($duplicate) return true;

        // Check by owner citizenship
        $owner = $registration->owner;
        if ($owner) {
            $duplicate = Registration::whereHas('owner', function ($q) use ($owner) {
                $q->where('citizenship_number', $owner->citizenship_number);
            })->where('id', '!=', $registration->id)->exists();
            if ($duplicate) return true;
        }

        // Check by PAN
        if ($registration->pan) {
            $duplicate = Registration::where('pan', $registration->pan)
                ->where('id', '!=', $registration->id)
                ->exists();
            if ($duplicate) return true;
        }

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
