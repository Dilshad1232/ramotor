<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    // Admin Dashboard
    public function index(Request $request)
    {
        return view('admin.dashboard'); // resources/views/admin/dashboard.blade.php
    }
}
