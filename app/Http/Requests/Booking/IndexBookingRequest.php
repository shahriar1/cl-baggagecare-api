<?php

namespace App\Http\Requests\Booking;

use App\Models\Booking;
use Illuminate\Validation\Rule;
use App\Http\Requests\Request;

class IndexBookingRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'booking_status' => ['', Rule::in(Booking::ALL_STATUS)],
            'email' => 'nullable|email', 
            'first_name' => 'nullable|string',
            'query' => 'string',
            'startDate' => 'date_format:Y-m-d',
            'endDate' => 'date_format:Y-m-d',
        ];
    }
}
