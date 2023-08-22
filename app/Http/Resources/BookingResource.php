<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class BookingResource extends Resource
{
    public function toArray(Request $request)
    {
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
            'released' => $this->released,
            'created_at' => $this->created_at,
        ];
    }
}
