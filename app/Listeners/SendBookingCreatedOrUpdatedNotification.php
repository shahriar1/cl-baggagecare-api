<?php

namespace App\Listeners;

use App\Events\BookingCreatedOrUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCreatedOrUpdatedNotification as BookingNotification;
use Illuminate\Support\Facades\App;

class SendBookingCreatedOrUpdatedNotification
{
    use InteractsWithQueue;

    public function handle(BookingCreatedOrUpdated $event)
    {

        $booking = $event->booking;
        $user_email = $booking->email;

        // if (!is_null($booking->selectedLanguage)) {

        //     App::setLocale($booking->selectedLanguage);
        // } else {
        //     App::setLocale('en');
        // }

        Mail::to($user_email)->send(new BookingNotification($event->booking));

        $admins = explode(',', env('ADMIN_EMAILS'));

        foreach ($admins as $adminEmail) {

            Mail::to($adminEmail)->send(new BookingNotification($event->booking));
        }
    }
}
