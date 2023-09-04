<?php

namespace App\Http\Requests;

class StorePaymentRequest extends Request
{

    public function rules()
    {
        return [
            'booking_id' => 'required|exists:bookings,id',
            'customer_email' => 'nullable|email',
            'amount_total' => 'nullable|numeric',
            'payment_intent_id' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'date' => 'nullable|date',
        ];
    }
}
