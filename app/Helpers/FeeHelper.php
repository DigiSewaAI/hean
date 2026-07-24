<?php

namespace App\Helpers;

class FeeHelper
{
    public static function getRenewalFee($capacity)
    {
        $tiers = config('hean.fees.renewal.tiers');
        foreach ($tiers as $tier) {
            if ($capacity <= $tier['max_capacity']) {
                return $tier['amount'];
            }
        }
        return 5000; // fallback
    }

    public static function getFee($type)
    {
        return config("hean.fees.{$type}", 0);
    }
}