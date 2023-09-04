<?php

namespace App\Http\Requests\Booking;

use App\Models\Booking;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
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
            'email' => 'nullable|email', // Allowing filtering by email
            'first_name' => 'nullable|string', // Allowing filtering by name
            'query' => 'string'
        ];
    }
}
