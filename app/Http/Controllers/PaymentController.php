<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentResourceCollection;
use App\Models\Payment;
use App\Repositories\Contracts\BookingRepository;
use App\Repositories\Contracts\PaymentRepository;
use App\Services\PaymentService;


class PaymentController extends Controller
{
    protected $paymentRepository;
    protected $paymentService;
    protected $bookingRepository;


    public function __construct(PaymentRepository $paymentRepository, BookingRepository $bookingRepository, PaymentService $paymentService)
    {
        $this->paymentRepository = $paymentRepository;
        $this->paymentService = $paymentService;
        $this->bookingRepository = $bookingRepository;
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
        $booking = $this->bookingRepository->findOne($bookingId);
        $paymentData = $booking->payment;

        $updateData = [
            'customer_email' => $session->customer_email,
            'amount_total' => $session->amount_total / 100,
            'payment_intent_id' => $session->payment_intent,
            'payment_method' => $session->payment_method_types[0],
            'payment_status' => $session->payment_status,
            'date' => now(),
        ];

        $this->paymentRepository->update($paymentData, $updateData);

        return redirect()->away(env('FRONTEND_URL') . "/booking-confirmation/{$bookingId}");
    }

    public function cancel()
    {
        return redirect()->away(env('FRONTEND_URL') . '/booking');
    }

    public function index()
    {
        $payments = $this->paymentRepository->findBy();

        return new PaymentResourceCollection($payments);
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = $this->paymentRepository->save($request->all());

        return new PaymentResource($payment);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment = $this->paymentRepository->update($payment, $request->all());
        return new PaymentResource($payment);
    }

    public function show($id)
    {
        $payment = $this->paymentRepository->findOne($id);
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
        $this->paymentRepository->delete($payment);

        return response()->json(null, 204);
    }
}
