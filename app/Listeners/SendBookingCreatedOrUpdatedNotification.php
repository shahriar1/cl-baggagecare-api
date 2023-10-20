<?php

namespace App\Listeners;

use App\Events\BookingCreatedOrUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCreatedOrUpdatedNotification as BookingNotification;

class SendBookingCreatedOrUpdatedNotification
{
    use InteractsWithQueue;

    public function handle(BookingCreatedOrUpdated $event)
    {

        $booking = $event->booking;
        $user_email = $booking->email;
        
        Mail::to($user_email)->send(new BookingNotification($event->booking));

        $admins = explode(',', env('ADMIN_EMAILS'));

        foreach ($admins as $adminEmail) {

            Mail::to($adminEmail)->send(new BookingNotification($event->booking));
        }
    }
}
