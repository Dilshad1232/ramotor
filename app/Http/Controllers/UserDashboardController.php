<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    //
    // User Dashboard
    public function index(Request $request)
    {
        return view('user.dashboard'); // resources/views/user/dashboard.blade.php
    }
}
