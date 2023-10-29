<?php

namespace App\Http\Requests\Booking;

use App\Http\Requests\Request;
use App\Models\Booking;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends Request
{
    public function rules()
    {
        return [
            'drop_off_date' => 'required|date',
            'drop_off_time' => 'nullable|string',
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'luggage_quantity' => 'required|integer',
            'phone_number' => 'required|string',
            'pick_up_date' => 'nullable|date',
            'pick_up_time' => 'nullable|string',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'released' => 'nullable|boolean',
            'payment_status' => 'required|string',
            'payment_method'=> 'required|string',
            'booking_status'=> ['nullable', 'string', Rule::in(Booking::ALL_STATUS)],
            'insuranceEnabled' => 'nullable|boolean', 
            'payment_amount' => 'nullable|numeric', 
            'insurance_amount' => 'nullable|numeric',
            'tips_amount' => 'nullable|numeric',
            'selectedLanguage' => 'nullable|string',
        ];
    }
}
