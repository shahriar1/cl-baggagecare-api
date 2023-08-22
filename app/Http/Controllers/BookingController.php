<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingResourceCollection;
use App\Models\Booking;
use App\Repositories\Contracts\BookingRepository;
use Illuminate\Http\Request;
use App\Events\BookingCreatedOrUpdated;
use App\Events\GenerateQrCode;
use App\Models\Payment;

class BookingController extends Controller
{

    
    protected $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index()
    {
        $bookings = $this->bookingRepository->findBy();
        return new BookingResourceCollection($bookings);
    }


    public function store(StoreBookingRequest $request)
    {
        $bookingData = $request->validated();

        $booking = $this->bookingRepository->save($bookingData);


        // Create a Payment record associated with the booking
        $paymentData = [
            'booking_id' => $booking->id,
            'customer_email' => $bookingData['email'],
            'amount_total' => $bookingData['total_price'],
            'payment_status' => $bookingData['payment_status'],
            'payment_method' => $bookingData['payment_method'],
            'date' => now(),
        ];
        $payment = Payment::create($paymentData);

        event(new GenerateQrCode($booking));

        event(new BookingCreatedOrUpdated($booking));
        $booking = Booking::with('payment')->find($booking->id);
        return new BookingResource($booking);
    }

    public function show(Booking $booking)
    {
        return new BookingResource($booking);
    }

    public function destroy(Booking $booking)
    {
        $this->bookingRepository->delete($booking);
        return response()->json(null, 204);
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $bookingData = $request->validated();

        // Update the booking data and associated payment data
        $booking = $this->bookingRepository->update($booking, $bookingData);

        return new BookingResource($booking);
    }
}
