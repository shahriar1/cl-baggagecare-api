<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class BookingResource extends Resource
{
    public function toArray(Request $request)
    {

        $this->load('payment');
        return [
            'id' => $this->id,
            'drop_off_date' => $this->drop_off_date,
            'drop_off_time' => $this->drop_off_time,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'luggage_quantity' => $this->luggage_quantity,
            'phone_number' => $this->phone_number,
            'pick_up_date' => $this->pick_up_date,
            'pick_up_time' => $this->pick_up_time,
            'total_price' => $this->total_price,
            'notes' => $this->notes,
            'qr_code' => $this->qr_code,
            'payment_qr_code' => $this->payment_qr_code,
            'released' => $this->released,
            'booking_status' => $this->booking_status,
            'tracking_number'=>$this->tracking_number,
            'created_at' => $this->created_at,

            // 'payment' => $this->payment ? [
            //     'id' => $this->payment->id,
            //     'customer_email' => $this->payment->customer_email,
            //     'amount_total' => $this->payment->amount_total,
            //     'payment_intent_id' => $this->payment->payment_intent_id,
            //     'payment_method' => $this->payment->payment_method,
            //     'payment_status' => $this->payment->payment_status,
            //     'date' => $this->payment->date,
            // ] : null,
            'payment' => new PaymentResource($this->whenLoaded('payment')), // Assuming you have a PaymentResource
        ];
    }
}
