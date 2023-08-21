<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request)
    {

        $url = $this->paymentService->createCheckoutSession($request->email, $request->total_price, $request->id);

        return response()->json([
            'url' => $url
        ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $session = $this->paymentService->retrieveSession($sessionId);

        $bookingId = $session->metadata->id;

        $this->paymentService->createOrUpdatePaymentRecord($session, $bookingId);

        return redirect()->away(env('FRONTEND_URL') . "/booking-confirmation/{$bookingId}");
    }

    public function cancel()
    {
        return redirect()->away(env('FRONTEND_URL') . '/booking');
    }
}
