<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ============================
    // Show Login Page (Web)
    // ============================
    public function showLogin()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // ============================
    // Show Register Page (Web)
    // ============================
    public function showRegister()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // ============================
    // Register User (Web + API)
    // ============================
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|string|max:15',
            'address'=> 'nullable|string|max:255',
            'city'=> 'nullable|string|max:255',
            'pincode'=> 'nullable|string|max:10',
            'password'=> 'required|min:5|confirmed',
            'profile_image'=> 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>'Validation Error','errors'=>$validator->errors()],422);
        }

        // Image upload
        $filename = null;
        if($request->hasFile('profile_image')){
            $filename = time().'_'.$request->profile_image->getClientOriginalName();
            $request->profile_image->move(public_path('uploads/profile'), $filename);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'city'=>$request->city,
            'pincode'=>$request->pincode,
            'password'=>Hash::make($request->password),
            'showpassword'=>$request->password,
            'profile_image'=>$filename,
            'role'=>'user',
            'status'=>1
        ]);

        // $token = $user->createToken('API_TOKEN')->plainTextToken;
        // Auth::login($user); // Auto login
        // return response()->json(['status'=>true,'message'=>'Registration Successful','token'=>$token,'user'=>$user->makeHidden(['password'])],201);
        return redirect()->back()->with('success', 'Registration Successful!');

    }

    // ============================
    // Login User (Web + API)
    // ============================
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if ($validator->fails()) {
    //         if ($request->expectsJson()) {
    //             return response()->json(['status'=>false,'errors'=>$validator->errors()],422);
    //         }
    //         return back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::where('email',$request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         if ($request->expectsJson()) {
    //             return response()->json(['status'=>false,'message'=>'Invalid credentials'],401);
    //         }
    //         return back()->withErrors(['email'=>'Invalid credentials'])->withInput();
    //     }

    //     if (!$request->expectsJson()) {
    //         Auth::login($user);
    //         return $user->role === 'admin'
    //             ? redirect()->route('admin.dashboard')
    //             : redirect()->route('user.dashboard');
    //     }

    //     $token = $user->createToken('API_TOKEN')->plainTextToken;
    //     return response()->json(['status'=>true,'token'=>$token,'role'=>$user->role,'user'=>$user->makeHidden(['password'])],200);
    // }


    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if ($validator->fails()) {
    //         if ($request->expectsJson()) {
    //             return response()->json(['status'=>false,'errors'=>$validator->errors()],422);
    //         }
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::where('email',$request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         if ($request->expectsJson()) {
    //             return response()->json(['status'=>false,'message'=>'Invalid credentials'],401);
    //         }
    //         return redirect()->back()->withErrors(['email'=>'Invalid credentials'])->withInput();
    //     }

    //     // ============================
    //     // Browser login → role-based dashboard
    //     // ============================
    //     if (!$request->expectsJson()) {
    //         Auth::login($user);
    //         if($user->role === 'admin'){
    //             return redirect()->route('admin.dashboard');
    //         } else {
    //             return redirect()->route('user.dashboard');
    //         }
    //     }

    //     // ============================
    //     // API login → token-based
    //     // ============================
    //     $token = $user->createToken('API_TOKEN')->plainTextToken;
    //     return response()->json([
    //         'status'=>true,
    //         'token'=>$token,
    //         'role'=>$user->role,
    //         'user'=>$user->makeHidden(['password'])
    //     ],200);
    // }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'=>'required|email',
        'password'=>'required'
    ]);

    if ($validator->fails()) {
        if ($request->expectsJson()) {
            return response()->json(['status'=>false,'errors'=>$validator->errors()],422);
        }
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = User::where('email',$request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        if ($request->expectsJson()) {
            return response()->json(['status'=>false,'message'=>'Invalid credentials'],401);
        }
        return redirect()->back()->withErrors(['email'=>'Invalid credentials'])->withInput();
    }

    if (!$request->expectsJson()) {
        // Browser login → use web guard
        Auth::guard('web')->login($user);

        if($user->role === 'admin'){
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    // API login → token-based
    $token = $user->createToken('API_TOKEN')->plainTextToken;
    return response()->json([
        'status'=>true,
        'token'=>$token,
        'role'=>$user->role,
        'user'=>$user->makeHidden(['password'])
    ],200);
}

    // ============================
    // Logout (Web + API)
    // ============================
    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status'=>true,'message'=>'Logged out'],200);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
