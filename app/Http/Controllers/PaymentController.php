<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [[
            'price_data' => [
                'currency' => 'usd',
                'unit_amount' => $request->total_price * 100, // Convert to cents
                'product_data' => [
                    'name' => 'Booking',
                ],
            ],
            'quantity' => 1,
        ]];

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $request->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('cancel', [], true),
        ]);

        return response()->json([
            'url' => $session->url
        ]);
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        $payment = new Payment();
        $payment->customer_email = $session->customer_email;
        $payment->amount_total = $session->amount_total / 100;;
        $payment->payment_intent_id = $session->payment_intent;
        $payment->payment_method = $session->payment_method_types[0];
        $payment->payment_status = $session->payment_status;
        $payment->date = now();
        $payment->save();

        return redirect()->away(env('FRONTEND_URL') . '/success');
    }

    public function cancel()
    {
        return redirect()->away(env('FRONTEND_URL') . '/booking');
    }
}
