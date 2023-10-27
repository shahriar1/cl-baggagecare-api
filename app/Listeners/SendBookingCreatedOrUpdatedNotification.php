<?php

namespace App\Listeners;

use App\Events\BookingCreatedOrUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCreatedOrUpdatedNotification as BookingNotification;
use App\Mail\AdminEmail as AdminBookingNotification;
use Illuminate\Support\Facades\App;

class SendBookingCreatedOrUpdatedNotification
{
    use InteractsWithQueue;

    public function handle(BookingCreatedOrUpdated $event)
    {

        $booking = $event->booking;
        $user_email = $booking->email;
        
        App::setLocale($booking->selectedLanguage);

        Mail::to($user_email)->send(new BookingNotification($event->booking));

        $admins = explode(',', env('ADMIN_EMAILS'));

        foreach ($admins as $adminEmail) {

            Mail::to($adminEmail)->send(new AdminBookingNotification($event->booking));
        }
    }
}
