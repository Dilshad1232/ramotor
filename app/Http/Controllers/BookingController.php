<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email',
            'service' => 'required',
            'service_date' => 'required|date',
            'special_request' => 'nullable|string',
            'phone' => 'required|string',

        ]);

        Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'service' => $request->service,
            'service_date' => $request->service_date,
            'special_request' => $request->special_request,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->withInput()->with([
            'success' => 'Booking request sent successfully!'
        ]);

    }
}
