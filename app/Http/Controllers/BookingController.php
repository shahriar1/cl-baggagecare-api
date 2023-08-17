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
        $booking = $this->bookingRepository->save($request->validated());

        event(new GenerateQrCode($booking));

        event(new BookingCreatedOrUpdated($booking));
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
        $booking = $this->bookingRepository->update($booking, $request->validated());
        return new BookingResource($booking);
    }
}
