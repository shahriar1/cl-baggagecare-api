<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_email',
        'amount_total',
        'payment_intent_id',
        'payment_method',
        'payment_status',
        'date',
    ];
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
