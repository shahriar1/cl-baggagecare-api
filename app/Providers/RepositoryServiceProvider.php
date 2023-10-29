<?php


namespace App\Providers;

use App\Models\Booking;
use App\Models\Payment;
use App\Repositories\Contracts\BookingRepository;
use App\Repositories\Contracts\PaymentRepository;
use App\Repositories\EloquentBookingRepository;
use App\Repositories\EloquentPaymentRepository;
use Carbon\Laravel\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookingRepository::class, function () {
            return new EloquentBookingRepository(new Booking());
        });
        $this->app->bind(PaymentRepository::class, function () {
            return new EloquentPaymentRepository(new Payment());
        });

    }
}
