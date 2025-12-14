<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Booking;

class PaymentController extends Controller
{
    // Razorpay payment page
    public function pay($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Amount in paise (₹499 = 49900)
        $amount = 49900;

        // Create Razorpay order
        $order = $api->order->create([
            'receipt' => 'booking_'.$booking->id,
            'amount' => $amount,
            'currency' => 'INR'
        ]);

        // Save order id in DB
        $booking->order_id = $order['id'];
        $booking->save();

        return view('payment', compact('booking', 'order', 'amount'));
    }

    // Payment success callback
    public function success(Request $request)
    {
        $booking = Booking::where('order_id', $request->razorpay_order_id)->firstOrFail();

        $booking->payment_id = $request->razorpay_payment_id;
        $booking->payment_status = 'paid';
        $booking->save();

        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Payment successful! Booking confirmed.');
    }

    //receipt page


public function receipt($id)
{
    $booking = Booking::findOrFail($id);

    $pdf = Pdf::loadView('receipt', compact('booking'));

    return $pdf->download('Booking_Receipt_'.$booking->id.'.pdf');
}

}
