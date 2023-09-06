<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\Request;

class StorePaymentRequest extends Request
{

    public function rules()
    {
        return [
            'booking_id' => 'required|exists:bookings,id',
            'customer_email' => 'required|email',
            'amount_total' => 'required|numeric',
            'payment_intent_id' => 'nullable|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'date' => 'nullable|date',
        ];
    }
}
