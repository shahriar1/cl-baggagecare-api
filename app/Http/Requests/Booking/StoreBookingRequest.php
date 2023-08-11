<?php

namespace App\Http\Requests\Booking;

use App\Http\Requests\Request;

class StoreBookingRequest extends Request
{
    public function rules()
    {
        return [
            'drop_off_date' => 'required|date',
            'drop_off_time' => 'required|string',
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'luggage_quantity' => 'required|integer',
            'phone_number' => 'required|string',
            'pick_up_date' => 'required|date',
            'pick_up_time' => 'required|string',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'released' => 'nullable|boolean',

        ];
    }
}
