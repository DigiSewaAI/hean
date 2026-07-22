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
        return [
            'registration_id' => 'required|exists:registrations,id',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.remarks' => 'nullable|string|max:500',
            'due_date' => 'nullable|date|after:today',
        ];
    }

    public function messages()
    {
        return [
            'items.required' => 'कम्तीमा एउटा आइटम चाहिन्छ।',
            'items.*.description.required' => 'प्रत्येक आइटमको विवरण दिनुहोस्।',
            'items.*.quantity.min' => 'मात्रा ० भन्दा बढी हुनुपर्छ।',
            'items.*.unit_price.min' => 'एकाइ मूल्य ऋणात्मक हुन सक्दैन।',
        ];
    }
}