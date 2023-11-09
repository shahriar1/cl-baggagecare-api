<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\StripeClient;
use App\Models\Payment;

class PaymentService
{
    protected $stripeSecret;

    public function __construct()
    {
        $this->stripeSecret = env('STRIPE_SECRET');
    }

    public function createCheckoutSession($email, $total_price, $id)
    {
        Stripe::setApiKey($this->stripeSecret);

        $lineItems = [[
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $total_price * 100, // Convert to cents
                'product_data' => [
                    'name' => 'Booking',
                ],
            ],
            'quantity' => 1,
        ]];

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $email,
            'line_items' => $lineItems,
            'mode' => 'payment',

            'success_url' => route('success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('cancel', [], true),
            'metadata' => [
                'id' => $id, // Set the booking_id in the metadata
            ],
            // 'expires_at' => strtotime('+7 days'),

        ]);

        return $session->url;
    }

    public function retrieveSession($sessionId)
    {
        $stripe = new StripeClient($this->stripeSecret);
        return $stripe->checkout->sessions->retrieve($sessionId);
    }

    public function createOrUpdatePaymentRecord($session, $bookingId)
    {
        $payment = Payment::where('booking_id', $bookingId)->first();
        if (!$payment) {
            // If payment record doesn't exist, create a new one
            $payment = new Payment();
            $payment->booking_id = $bookingId; // Associate payment with the booking
            $payment->customer_email = $session->customer_email;
            $payment->amount_total = $session->amount_total / 100;
            $payment->payment_intent_id = $session->payment_intent;
            $payment->payment_method = $session->payment_method_types[0];
            $payment->payment_status = $session->payment_status;
            $payment->date = now();
            $payment->save();
        }
        // Update payment details
        $payment->customer_email = $session->customer_email;
        $payment->amount_total = $session->amount_total / 100;
        $payment->payment_intent_id = $session->payment_intent;
        $payment->payment_method = $session->payment_method_types[0];
        $payment->payment_status = $session->payment_status;
        $payment->date = now();
        $payment->save();
    }
}
