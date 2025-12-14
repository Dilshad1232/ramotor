<?php
namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Booking;
use Mail;
use Razorpay\Api\Api;
use Twilio\Rest\Client; // ✅ Twilio SDK ka Client

class BookingController extends Controller
{
    // Booking form page
    public function booking()
    {
        return view('booking');
    }

    // Booking submit/store
    public function store(Request $request)
    {
        // 🔹 Validation
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'service'         => 'required|string|max:255',
            'service_date'    => 'required|date',
            'special_request' => 'nullable|string|max:500',
            'phone'           => 'required|string|max:15',
            'address'         => 'nullable|string|max:500',
        ]);

        // 🔹 Booking create
        $booking = Booking::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'service'         => $request->service,
            'service_date'    => $request->service_date,
            'special_request' => $request->special_request,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'amount'          => $request->amount,  // Default amount set to 100
        ]);

        // // 🔹 Send Email to user
        // Mail::to($booking->email)->send(new BookingConfirmation($booking));

        // // 🔹 Send Email to Admin
        // Mail::to(env('ADMIN_EMAIL', 'admin@example.com'))->send(new BookingConfirmation($booking));

        // 🔹 Send SMS using Twilio
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $message = "Dear {$booking->name}, your booking for {$booking->service} on {$booking->service_date} is confirmed. - Indian Color Point & Autoglass";

        // ✅ Make sure to include country code in phone number
        $twilio->messages->create(
            '+91'.$booking->phone, // India country code
            [
                'from' => env('TWILIO_PHONE'),
                'body' => $message
            ]
        );

        // return redirect()->back()->with([
        //     'success' => 'Booking request sent successfully! Email & SMS confirmation sent.',
        //     'name' => $booking->name,
        //     'email' => $booking->email,
        //     'service' => $booking->service,
        //     'service_date' => $booking->service_date,
        //     'special_request' => $booking->special_request,
        //     'phone' => $booking->phone,
        //     'address' => $booking->address,
        // ]);

           // 🔹 Razorpay Payment Order
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    $paymentOrder = $api->order->create([
        'receipt' => 'booking_rcpt_'.$booking->id,
        'amount' => 10000, // ₹100.00 (amount in paise)
        'currency' => 'INR',
        'payment_capture' => 1 // auto capture
    ]);

    $booking->razorpay_order_id = $paymentOrder['id'];
    $booking->save();

    return view('booking_payment', compact('booking', 'paymentOrder'));


   }


   // Payment verification

   public function verifyPayment(Request $request)
{
    $request->validate([
        'razorpay_payment_id' => 'required',
        'razorpay_order_id' => 'required',
        'razorpay_signature' => 'required',
    ]);

    $booking = Booking::where('razorpay_order_id', $request->razorpay_order_id)->first();

    if(!$booking) return redirect()->route('booking')->with('error','Booking not found');

    // Signature verify
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    $attributes  = [
        'razorpay_order_id' => $request->razorpay_order_id,
        'razorpay_payment_id' => $request->razorpay_payment_id,
        'razorpay_signature' => $request->razorpay_signature
    ];

    try {
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ]);

        $booking->status = 'pending';
        $booking->payment_status = 'paid';
        $booking->razorpay_payment_id = $request->razorpay_payment_id;
        $booking->razorpay_signature = $request->razorpay_signature;
        $booking->save();

        return redirect()->route('booking.confirmation', $booking->id);
    } catch (\Exception $e) {
        return redirect()->route('booking')->with('error', 'Payment verification failed.');
    }


}


//


public function downloadReceipt($id)
{
    $booking = Booking::findOrFail($id);
    $pdf = Pdf::loadView('receipt', compact('booking'));
    return $pdf->download('receipt_booking_'.$booking->id.'.pdf');
}


public function confirmation($id)
{
    $booking = Booking::findOrFail($id);
    return view('booking_confirmation', compact('booking'));
}

}
