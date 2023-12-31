<?php

namespace App\Listeners;

use App\Events\GenerateQrCode;
use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCodeListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(GenerateQrCode $event)
    {

        $url = env('FRONTEND_URL');
        $booking = $event->booking;
        $bookingId = $booking->id;

        $qrCodeData = "{$url}/admin/booking-list/{$bookingId}";

        $qrCodeImage = QrCode::format('png')->size(200)->generate($qrCodeData);

        // Convert the QR code image to base64
        $qrCodeBase64 = base64_encode($qrCodeImage);

        // Update the booking model with the QR code
        Booking::query()->where('id', $booking->id)->update(['qr_code' => $qrCodeBase64]);
    }
}
