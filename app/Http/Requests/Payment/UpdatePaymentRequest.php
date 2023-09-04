<?php

namespace App\Http\Requests;


class UpdatePaymentRequest extends Request
{

    public function rules()
    {
        return [
            'customer_email' => 'nullable|email',
            'amount_total' => 'nullable|numeric',
            'payment_intent_id' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'date' => 'nullable|date',
        ];
    }
}
