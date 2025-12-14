<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Static pages
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/services',[HomeController::class,'services'])->name('services');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');
Route::get('/booking',[BookingController::class,'booking'])->name('booking');
Route::get('/team',[HomeController::class,'team'])->name('team');
Route::get('/testimonial',[HomeController::class,'testimonial'])->name('testimonial');
Route::get('/404',[HomeController::class,'notFound'])->name('notFound');

// Route::post('/home/booking/store', [BookingController::class, 'homebookingstore'])->name('home.booking.store');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');

// Guest routes (login/register)
Route::middleware('guest:web')->group(function(){
    Route::get('login',[AuthController::class,'showLogin'])->name('login');
    Route::post('login',[AuthController::class,'login'])->name('login.submit');
    Route::get('register',[AuthController::class,'showRegister'])->name('register');
    Route::post('register',[AuthController::class,'register'])->name('register.submit');

});






// Logout route (auth)
Route::post('logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');

// Protected User routes
Route::middleware(['auth:web','user'])->group(function(){
    Route::get('/user/dashboard',[UserDashboardController::class,'index'])->name('user.dashboard');

// Admin profile routes
// web.php
Route::get('user/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
Route::post('user/profile/update', [UserDashboardController::class, 'profile_update'])->name('user.profile.update');
Route::get('user/profile/edit', [UserDashboardController::class, 'profile_edit'])->name('user.profile.edit');
Route::get('user/invoice', [UserDashboardController::class, 'invoice'])->name('user.invoice');

// my services
Route::get('/user/services', [UserDashboardController::class, 'my_services'])->name('user.services');
Route::get('/user/book-service', [UserDashboardController::class, 'book_service'])->name('user.book-service');
Route::post('/user/booking/cancel/{id}', [UserDashboardController::class, 'cancel_booking'])->name('user.booking.cancel');
Route::get('/user/schedule-service', [UserDashboardController::class, 'schedule_service'])->name('user.schedule_service');
Route::put('/user/reschedule/{id}', [UserDashboardController::class, 'reschedule_service'])->name('user.reschedule_service');
Route::get('/user/statistics', [UserDashboardController::class, 'statistics'])->name('user.statistics');
Route::get('/user/contact', [UserDashboardController::class, 'contact'])->name('user.contact');
});

// Protected Admin routes
Route::middleware(['auth:web','admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/admin/customers',[AdminDashboardController::class,'customers'])->name('admin.customers');
    Route::get('/admin/customer/{id}', [AdminDashboardController::class, 'customerDetails'])->name('admin.customer.details');
    Route::delete('/admin/customer/delete/{id}', [AdminDashboardController::class, 'deleteCustomer'])->name('admin.customer.delete');

    Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('admin.services');
    Route::post('/admin/services/store', [ServiceController::class, 'store'])->name('admin.services.store'); // admin form
// Edit Page
Route::get('/admin/services/{id}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');

// Update
Route::put('/admin/services/{id}', [ServiceController::class, 'update'])->name('admin.services.update');

// Delete
Route::delete('/admin/services/{id}', [ServiceController::class, 'delete'])->name('admin.services.delete');
Route::post('admin/booking/{id}/approve', [AdminDashboardController::class, 'approveBooking'])->name('admin.booking.approve');
Route::post('admin/booking/{id}/reject', [AdminDashboardController::class, 'rejectBooking'])->name('admin.booking.reject');
Route::get('/admin/bookings', [AdminDashboardController::class, 'bookings'])->name('admin.bookings');
Route::get('/admin/mechanic', [AdminDashboardController::class, 'add_mechanic'])->name('admin.mechanic');
Route::post('admin/mechanics', [AdminDashboardController::class, 'mechanic_store'])->name('admin.mechanic.store');
Route::delete('admin/mechanics/{id}', [AdminDashboardController::class, 'mechanic_destroy'])->name('admin.mechanic.destroy');

Route::get('admin/mechanics/specializations', [AdminDashboardController::class, 'mechanic_specializations'])->name('admin.mechanic.specializations');

//add user
Route::get('admin/add-user', [AdminDashboardController::class, 'add_user'])->name('admin.add-user');
Route::post('admin/user/store', [AdminDashboardController::class, 'user_store'])->name('admin.user.store');

// Admin profile routes
// web.php
Route::get('admin/profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
Route::post('admin/profile/update', [AdminDashboardController::class, 'profile_update'])->name('admin.profile.update');
Route::get('admin/profile/edit', [AdminDashboardController::class, 'profile_edit'])->name('admin.profile.edit');
Route::get('admin/bill', [AdminDashboardController::class, 'bill'])->name('admin.bill');
Route::get('admin/search-user', [AdminDashboardController::class, 'searchUser'])->name('admin.search-user');
Route::get('admin/contactview', [AdminDashboardController::class, 'contactView'])->name('admin.contactview');
Route::delete('admin/contact/delete/{id}', [AdminDashboardController::class, 'contactdestroy'])
    ->name('admin.contact.delete');
});


// Razorpay Payment Routes
Route::get('/payment/{booking_id}', [PaymentController::class, 'pay'])->name('payment');
Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/booking/confirmation/{id}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
// Receipt route
Route::get('/booking/receipt/{id}', [PaymentController::class, 'receipt'])->name('booking.receipt');

// payment verification route
Route::post('/payment/verify', [BookingController::class, 'verifyPayment'])->name('payment.verify');

