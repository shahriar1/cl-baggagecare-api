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
use SimpleSoftwareIO\QrCode\Facades\QrCode;



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
    public function qr()
    {
        return view('qrcode');
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingRepository->save($request->validated());

        $url = env('FRONTEND_URL');
        $bookingId = $booking->id;
        $qrCodeData = "{$url}/booking-confirmation/{$bookingId}";


        $qrCodeImage = QrCode::format('png')->size(200)->generate($qrCodeData);

        // Convert the QR code image to base64
        $qrCodeBase64 = base64_encode($qrCodeImage);

        // Store the base64-encoded QR code in the 'qr_code' column
        Booking::query()->where('id', $booking->id)->update(['qr_code' => $qrCodeBase64]);
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
