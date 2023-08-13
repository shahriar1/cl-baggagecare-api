<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_email',
        'amount_total',
        'payment_intent_id',
        'payment_method',
        'payment_status',
        'date',
    ];
}
