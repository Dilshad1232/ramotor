<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // ===========================
            // 🔹 Customer Basic Details
            // ===========================
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');

            // ===========================
            // 🔹 Service Booking Details
            // ===========================
            $table->string('service');
            $table->date('service_date');
            $table->text('special_request')->nullable();

                        // ===========================
            // 🔹 Booking Amount (Fixed Payment)
            // ===========================
            // User ko kitna pay karna hai (default 100 Rs)
            $table->integer('amount')->default(100);

            // ===========================
            // 🔹 Booking Status
            // pending | approved | completed | cancelled
            // ===========================
            $table->string('status')->default('pending');

            // ===========================
            // 🔹 Payment Fields (Razorpay)
            // ===========================

            // Payment Status: unpaid | paid | failed
            $table->string('payment_status')->default('unpaid');

            // Razorpay generated IDs used for tracking
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
