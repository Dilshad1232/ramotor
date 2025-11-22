<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;

Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function(){

    // Logout & profile
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    // User dashboard routes
    Route::middleware('user')->group(function(){
        Route::get('/user/dashboard', function(){
            return response()->json(['status'=>true, 'message'=>'User Dashboard']);
        });
    });

    // Admin dashboard routes
    Route::middleware('admin')->group(function(){
        Route::get('/admin/dashboard', function(){
            return response()->json(['status'=>true, 'message'=>'Admin Dashboard']);
        });
    });
});
