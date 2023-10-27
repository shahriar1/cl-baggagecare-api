<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Booking extends Model
{
    use HasFactory;

    const STATUS_IN_PROGRESS = "check-in";
    const STATUS_DELIVERED = "check-out";
    const STATUS_PENDING = "pending";
    const STATUS_CANCELLED = "cancelled";

    const ALL_STATUS = [self::STATUS_DELIVERED, self::STATUS_IN_PROGRESS, self::STATUS_PENDING,self::STATUS_CANCELLED];
   
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
        'tracking_number',
        'payment_amount',
        'insurance_amount',
        'tips_amount',
        'insuranceEnabled',
        'selectedLanguage'
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($booking) {
            $url = env('FRONTEND_URL');
            $qrCodeData = "{$url}/admin/booking-list/{$booking->id}";
            $qrCodeImage = QrCode::format('png')->size(200)->generate($qrCodeData);
            $qrCodeBase64 = base64_encode($qrCodeImage);
            $booking->qr_code = $qrCodeBase64;
            $booking->save();
        });
    }
    
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
