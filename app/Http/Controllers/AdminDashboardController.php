<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mechanic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    //

    public function index(Request $request)
    {


        $totalCustomers = User::where('role','user')->count();
        $totalBookedServices = Booking::count();
        $pendingServices = Booking::where('status','pending')->count();
        $completedServices = Booking::where('status','approved')->count(); // Completed = Approved
        // $todayAppointments = Booking::whereDate('service_date', now())->count();
        $todayAppointments = Booking::whereDate('created_at', now())->count();

        // Latest booked services with pagination, search & limit
        $search = $request->input('search');
        $limit  = $request->input('limit', 5);

        $latestBookings = Booking::when($search, function($q) use($search){
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%")
                  ->orWhere('service','like',"%$search%");
            })
            ->orderBy('created_at','desc')
            ->paginate($limit);

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalBookedServices',
            'pendingServices',
            'completedServices',
            'todayAppointments',
            'latestBookings'
        ));
    }

    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'approved';
        $booking->save();
        return back()->with('success','Booking approved successfully!');
    }

    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'rejected';
        $booking->save();
        return back()->with('success','Booking rejected successfully!');
    }

    // Bookings Management Page
    public function bookings(Request $request)
    {
        $search = $request->input('search');
        $limit  = $request->input('limit', 5); // default 5 rows

        $latestBookings = Booking::when($search, function($q) use($search){
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%")
                  ->orWhere('service','like',"%$search%");
            })
            ->orderBy('created_at','desc')
            ->paginate($limit)
            ->appends(['search' => $search, 'limit' => $limit]);

        return view('admin.booking_order_manage', compact('latestBookings', 'search', 'limit'));
    }
        // });

    // Admin Customers Page
    public function customers(Request $request)
    {
        $search = $request->input('search');
        $limit  = $request->input('limit', 5); // default 5 rows

        $users = User::where('role', 'user')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%");
            })
            ->orderBy('id', 'DESC')
            ->paginate($limit)
            ->appends(['search' => $search, 'limit' => $limit]);

        return view('admin.customers', compact('users', 'search', 'limit'));
    }

    // Admin Customer Details Page
    public function customerDetails($id)
{
    $customer = User::where('role', 'user')->findOrFail($id);
    return view('admin.customer_details', compact('customer'));
}

    // Delete Customer
    public function deleteCustomer($id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);

        // Profile image delete from uploads/profile folder
        if ($customer->profile_image && file_exists(public_path('uploads/profile/' . $customer->profile_image))) {
            unlink(public_path('uploads/profile/' . $customer->profile_image));
        }

        // Delete customer record
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }

    public function add_mechanic()
    {
        $mechanics = Mechanic::latest()->get();
        return view('admin.add_mechanic', compact('mechanics'));
    }
     // Store mechanic
     public function mechanic_store(Request $request)
     {
         $request->validate([
             'name'  => 'required|string|max:255',
             'email' => 'required|email|max:255',
             'phone' => 'required',
             'specialization' => 'required|string|max:255',
             'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
         ]);

         // Handle Image Upload
         $imagePath = null;
         if ($request->hasFile('profile_image')) {
             $image = $request->file('profile_image');
             $imageName = time().'_'.$image->getClientOriginalName(); // original name with timestamp
             $image->move(public_path('uploads/mechanic'), $imageName);
             $imagePath = 'uploads/mechanic/' . $imageName;
         }

         // Save to database
         Mechanic::create([
             'name' => $request->name,
             'email' => $request->email,
             'phone' => $request->phone,
             'specialization' => $request->specialization,
             'profile_image' => $imagePath,
         ]);

         return redirect()->route('admin.mechanic')->with('success', 'Mechanic Added Successfully!');
     }

     public function mechanic_destroy($id)
     {
         // Fetch the mechanic
         $mechanic = Mechanic::findOrFail($id);

         // Delete profile image if exists
         if ($mechanic->profile_image && File::exists(public_path($mechanic->profile_image))) {
             File::delete(public_path($mechanic->profile_image));
         }

         // Delete mechanic
         $mechanic->delete();

         return redirect()->route('admin.mechanic')->with('success', 'Mechanic Deleted Successfully!');
     }

     // Mechanic Specializations Page
     public function mechanic_specializations()
{
    $mechanics = Mechanic::all(); // sab mechanics la lo
    return view('admin.specializations', compact('mechanics'));
}

// Admin Profile Page


public function profile()
{
    $admin = Auth::user();
    return view('admin.profile', compact('admin'));
}

public function profile_edit()
{
    $admin = Auth::user();
    return view('admin.profile_edit', compact('admin'));
}
public function profile_update(Request $request)
{
    $admin = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        'phone' => 'required|string|max:20',
        'password' => 'nullable|min:6|confirmed',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'pincode' => 'nullable|string|max:10',
    ]);

    // Update normal fields
    $admin->fill([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'city' => $request->city,
        'pincode' => $request->pincode,
    ]);

    if ($request->password) {
        $admin->password = Hash::make($request->password);
    }

    // =====================
    // IMAGE HANDLING
    // =====================
    if ($request->hasFile('profile_image')) {

        // DELETE OLD IMAGE
        if ($admin->profile_image && file_exists(public_path('uploads/admin/' . $admin->profile_image))) {
            unlink(public_path('uploads/admin/' . $admin->profile_image));
        }

        // UPLOAD NEW IMAGE
        $file = $request->file('profile_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/admin'), $filename);

        $admin->profile_image = $filename;

    } else {

        // NO NEW IMAGE → REMOVE OLD
        // if ($admin->profile_image && file_exists(public_path('uploads/admin/' . $admin->profile_image))) {
        //     unlink(public_path('uploads/admin/' . $admin->profile_image));
        // }

        // $admin->profile_image = null;
    }

    $admin->save();

    return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
}
}
