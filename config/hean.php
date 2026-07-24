<?php

return [
    /*
    |--------------------------------------------------------------------------
    | HEAN Fee Structure
    |--------------------------------------------------------------------------
    |
    | This file contains all fee rates and invoice types used in the HEAN system.
    | These rates are based on the official rate list from the association.
    |
    */

    'fees' => [
        'renewal' => [
            'tiers' => [
                ['max_capacity' => 30, 'amount' => 2000],
                ['max_capacity' => 50, 'amount' => 3000],
                ['max_capacity' => 80, 'amount' => 4000],
                ['max_capacity' => PHP_INT_MAX, 'amount' => 5000],
            ],
        ],
        'membership' => 2000,
        'inspection' => 500,
        'certificate' => 0,
        'penalty' => 0,
        'log_book' => 200,
        'leave_form' => 200,
        'student_admission_form' => 10, // per piece
        'code_of_conduct_board' => 1000,
        'recommendation' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Types (Fee Types)
    |--------------------------------------------------------------------------
    |
    | All invoice types supported by the system. These are used in dropdowns
    | and for auto-generation of invoice items.
    |
    */
    'invoice_types' => [
        'new_registration',
        'renewal',
        'inspection_fee',
        'certificate_fee',
        'penalty',
        'log_book',
        'leave_form',
        'student_admission_form',
        'code_of_conduct_board',
        'recommendation',
        'other',
    ],
];