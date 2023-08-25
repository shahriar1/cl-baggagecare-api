<?php

namespace App\Http\Requests\Booking;

use App\Http\Requests\Request;

class UpdateBookingRequest extends Request
{
    public function rules()
    {
        return [
            'drop_off_date' => 'date',
            'drop_off_time' => 'string',
            'email' => 'email',
            'first_name' => 'string',
            'last_name' => 'string',
            'luggage_quantity' => 'integer',
            'phone_number' => 'string',
            'pick_up_date' => 'date',
            'pick_up_time' => 'string',
            'total_price' => 'numeric',
            'notes' => 'nullable|string',
            'released' => 'nullable|boolean',
            'payment_status' => 'required|string', 
            'payment_method'=> 'nullable|string',
            'booking_status'=> 'nullable|string',

        ];
    }
}
