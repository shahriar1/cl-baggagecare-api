<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'drop_off_date',
        'drop_off_time',
        'email',
        'first_name',
        'last_name',
        'luggage_quantity',
        'phone_number',
        'pick_up_date',
        'pick_up_time',
        'total_price',
        'notes',
        'released',
        'qr_code,',
        'payment_qr_code',
        'booking_status',
    ];
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
