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

    public function createCheckoutSession($email, $totalPrice)
    {
        Stripe::setApiKey($this->stripeSecret);

        $lineItems = [[
            'price_data' => [
                'currency' => 'usd',
                'unit_amount' => $totalPrice * 100, // Convert to cents
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
        ]);

        return $session->url;
    }

    public function retrieveSession($sessionId)
    {
        $stripe = new StripeClient($this->stripeSecret);
        return $stripe->checkout->sessions->retrieve($sessionId);
    }

    public function createPaymentRecord($session)
    {
        $payment = new Payment();
        $payment->customer_email = $session->customer_email;
        $payment->amount_total = $session->amount_total / 100;
        $payment->payment_intent_id = $session->payment_intent;
        $payment->payment_method = $session->payment_method_types[0];
        $payment->payment_status = $session->payment_status;
        $payment->date = now();
        $payment->save();
    }
}
