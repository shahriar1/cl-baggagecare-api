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
        $url = $this->paymentService->createCheckoutSession($request->email, $request->total_price);

        return response()->json([
            'url' => $url
        ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $session = $this->paymentService->retrieveSession($sessionId);

        $this->paymentService->createPaymentRecord($session);

        return redirect()->away(env('FRONTEND_URL') . '/success');
    }

    public function cancel()
    {
        return redirect()->away(env('FRONTEND_URL') . '/booking');
    }
}
