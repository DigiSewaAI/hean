<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Admin middleware ले पहिले नै गर्छ
    }

    public function rules()
    {
        // Get invoice types from config for validation
        $invoiceTypes = implode(',', config('hean.invoice_types', []));

        return [
            'registration_id' => 'required|exists:registrations,id',

            // 🔥 NEW: fee_type for auto-generation
            'fee_type' => 'nullable|string|in:' . $invoiceTypes,

            // Manual items (required if fee_type not provided)
            'items' => 'required_without:fee_type|array|min:1',
            'items.*.description' => 'required_without:fee_type|string|max:255',
            'items.*.quantity' => 'required_without:fee_type|numeric|min:0.01',
            'items.*.unit_price' => 'required_without:fee_type|numeric|min:0',
            'items.*.remarks' => 'nullable|string|max:500',

            // Discount, tax (optional)
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',

            // Due date
            'due_date' => 'nullable|date|after:today',
        ];
    }

    public function messages()
    {
        return [
            'registration_id.required' => 'कृपया दर्ता चयन गर्नुहोस्।',
            'registration_id.exists' => 'दर्ता फेला परेन।',

            'fee_type.in' => 'अमान्य शुल्क प्रकार।',

            'items.required_without' => 'कम्तीमा एउटा आइटम चाहिन्छ वा शुल्क प्रकार चयन गर्नुहोस्।',
            'items.*.description.required_without' => 'प्रत्येक आइटमको विवरण दिनुहोस्।',
            'items.*.quantity.min' => 'मात्रा ० भन्दा बढी हुनुपर्छ।',
            'items.*.unit_price.min' => 'एकाइ मूल्य ऋणात्मक हुन सक्दैन।',

            'discount.min' => 'छुट ऋणात्मक हुन सक्दैन।',
            'tax.min' => 'कर ऋणात्मक हुन सक्दैन।',

            'due_date.after' => 'मिति आज भन्दा पछिको हुनुपर्छ।',
        ];
    }
}