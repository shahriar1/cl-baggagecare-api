<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    const STATUS_IN_PROGRESS = "received";
    const STATUS_DELIVERED = "delivered";
    const STATUS_PENDING = "pending";

    const ALL_STATUS = [self::STATUS_DELIVERED, self::STATUS_IN_PROGRESS, self::STATUS_PENDING];
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
