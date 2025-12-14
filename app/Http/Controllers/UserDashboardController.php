<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    //
    // User Dashboard
    // public function index(Request $request)
    // {
    //     $totalCars = Booking::count();

    //     $denting = Booking::where('service', 'Denting')->count();
    //     $painting = Booking::where('service', 'Painting')->count();
    //     $engine_repair = Booking::where('service', 'Engine Repair')->count(); // corrected

    //     return view('user.dashboard', [
    //         'bookings' => Booking::orderBy('id','DESC')->limit(5)->get(),
    //         'stats' => [
    //             ['Total Cars', $totalCars, '🚗', '#ff4d4d'],
    //             ['Denting', $denting, '🛠️', '#ff6666'],
    //             ['Painting', $painting, '🎨', '#ff3333'],
    //             ['Engine Repair', $engine_repair, '⚙️', '#ff1a1a'], // corrected
    //         ],
    //     ]);
    // }
    // use Illuminate\Support\Facades\Auth;

public function index(Request $request)
{
    $userEmail = Auth::user()->email; // login user ka email

    $totalCars = Booking::where('email', $userEmail)->count();

    $denting = Booking::where('email', $userEmail)->where('service', 'Denting')->count();
    $painting = Booking::where('email', $userEmail)->where('service', 'Painting')->count();
    $engine_repair = Booking::where('email', $userEmail)->where('service', 'Engine Repair')->count();

    return view('user.dashboard', [
        'bookings' => Booking::where('email', $userEmail)->orderBy('id','DESC')->get(),
        'stats' => [
            ['Total Cars', $totalCars, '🚗', '#ff4d4d'],
            ['Denting', $denting, '🛠️', '#ff6666'],
            ['Painting', $painting, '🎨', '#ff3333'],
            ['Engine Repair', $engine_repair, '⚙️', '#ff1a1a'],
        ],
    ]);
}

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    public function profile_edit()
    {
        $user = Auth::user();
        return view('user.profile_edit', compact('user'));
    }
    public function profile_update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        // Update normal fields
        $user->fill([
            'name' => $request->name,
            // 'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // =====================
        // IMAGE HANDLING
        // =====================
        if ($request->hasFile('profile_image')) {

            // DELETE OLD IMAGE
            if ($user->profile_image && file_exists(public_path('uploads/profile/' . $user->profile_image))) {
                unlink(public_path('uploads/profile/' . $user->profile_image));
            }

            // UPLOAD NEW IMAGE
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);

            $user->profile_image = $filename;

        } else {

            // NO NEW IMAGE → REMOVE OLD
            // if ($admin->profile_image && file_exists(public_path('uploads/admin/' . $admin->profile_image))) {
            //     unlink(public_path('uploads/admin/' . $admin->profile_image));
            // }

            // $admin->profile_image = null;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }
    public function invoice(){
        return view('user.invoices');
    }
        public function my_services(Request $request)
        {
            $email = Auth::user()->email;

            $query = Booking::where('email', $email);

            // Optional search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search){
                    $q->where('service', 'like', "%$search%")
                      ->orWhere('status', 'like', "%$search%");
                });
            }

            $limit = $request->limit ?? 10;
            $bookings = Booking::whereRaw('LOWER(email) = ?', [strtolower(auth()->user()->email)])
            ->orderBy('service_date','desc')
            ->paginate(5)
            ->withQueryString();

            return view('user.my-services', compact('bookings'));
        }

        // Book Service
        public function book_service(){
            return view('user.book-service');
        }
        // Cancel Booking


public function cancel_booking($id)
{
    $booking = Booking::where('id', $id)
                      ->where('email', Auth::user()->email)
                      ->first();

    if (!$booking) {
        return redirect()->back()->with('error', 'Booking not found.');
    }

    if ($booking->status == 'rejected' || $booking->status == 'cancelled') {
        return redirect()->back()->with('error', 'Booking already cancelled.');
    }

    $booking->status = 'rejected';
    $booking->save();

    return redirect()->back()->with('success', 'Booking cancelled successfully.');
}

        // Schedule Service
        public function schedule_service(Request $request)
        {
            $query = Booking::where('email', Auth::user()->email);

            // Search by service name or status
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search){
                    $q->where('service', 'like', "%$search%")
                      ->orWhere('status', 'like', "%$search%");
                });
            }

            // Filter by status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Pagination limit
            $limit = $request->get('limit', 6);

            $bookings = $query->orderBy('service_date','desc')->paginate($limit)->withQueryString();

            return view('user.schedule-services', compact('bookings'));
        }

        // Reschedule service
        public function reschedule_service(Request $request, $id)
        {
            $request->validate([
                'new_date' => 'required|date|after_or_equal:today',
            ]);

            $booking = Booking::findOrFail($id);

            // Approved booking ko reschedule nahi karna
            if($booking->status === 'approved') {
                return redirect()->back()->with('error', 'Approved bookings cannot be rescheduled.');
            }

            // Agar cancel hai to pending me change
            if($booking->status === 'rejected') {
                $booking->status = 'pending';
            }

            $booking->service_date = $request->new_date;
            $booking->save();

            return redirect()->back()->with('success', 'Booking rescheduled successfully.');
        }




        public function statistics() {
            $userEmail = auth()->user()->email;

            $bookings = Booking::where('email', $userEmail)->get();

            $totalBookings = $bookings->count();
            $pending = $bookings->where('status','pending')->count();
            $approved = $bookings->where('status','approved')->count();
            $rejected = $bookings->where('status','rejected')->count();

            // Monthly Trend (last 6 months)
            $months = [];
            $monthlyPending = [];
            $monthlyApproved = [];
            $monthlyRejected = [];

            for($i=5; $i>=0; $i--){
                $month = now()->subMonths($i);
                $months[] = $month->format('M');

                $monthlyPending[] = Booking::where('email',$userEmail)
                                        ->where('status','pending')
                                        ->whereMonth('service_date',$month->month)
                                        ->count();

                $monthlyApproved[] = Booking::where('email',$userEmail)
                                        ->where('status','approved')
                                        ->whereMonth('service_date',$month->month)
                                        ->count();

                $monthlyRejected[] = Booking::where('email',$userEmail)
                                        ->where('status','rejected')
                                        ->whereMonth('service_date',$month->month)
                                        ->count();
            }

            return view('user.statistics', compact(
                'totalBookings','pending','approved','rejected',
                'months','monthlyPending','monthlyApproved','monthlyRejected'
            ));
        }

        public function contact(Request $request)
        {
            return view('user.contact');
        }

    }




