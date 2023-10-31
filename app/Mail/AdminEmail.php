<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;


class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        $trackingNumber = $this->booking->tracking_number;
        $trackingNumberUpper = strtoupper($trackingNumber);

        return $this->subject("New Booking - {$trackingNumberUpper}")
            ->view('emails.booking_created_or_updated');
    }
}
