<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Static pages
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/services',[HomeController::class,'services'])->name('services');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');
Route::get('/booking',[HomeController::class,'booking'])->name('booking');
Route::get('/team',[HomeController::class,'team'])->name('team');
Route::get('/testimonial',[HomeController::class,'testimonial'])->name('testimonial');
Route::get('/404',[HomeController::class,'notFound'])->name('notFound');

// Guest routes (login/register)
Route::middleware('guest:web')->group(function(){
    Route::get('login',[AuthController::class,'showLogin'])->name('login');
    Route::get('register',[AuthController::class,'showRegister'])->name('register');
    Route::post('login',[AuthController::class,'login'])->name('login.submit');
    Route::post('register',[AuthController::class,'register'])->name('register.submit');
});


// Logout route (auth)
Route::post('logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');

// Protected User routes
Route::middleware(['auth:web','user'])->group(function(){
    Route::get('/user/dashboard',[UserDashboardController::class,'index'])->name('user.dashboard');
});

// Protected Admin routes
Route::middleware(['auth:web','admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
});
