<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class BookingCreatedOrUpdatedNotification extends Mailable
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

        return $this->subject("BaggageCare Booking Confirmation - {$trackingNumberUpper}")
            ->view('emails.booking_created_or_updated');
    }
}
