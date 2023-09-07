<?php

namespace App\Http\Resources;

class PaymentResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'customer_email' => $this->customer_email,
            'amount_total' => $this->amount_total,
            'payment_intent_id' => $this->payment_intent_id,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
