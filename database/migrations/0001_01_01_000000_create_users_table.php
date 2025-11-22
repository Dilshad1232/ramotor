<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic required fields
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');

            // Optional but recommended fields
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();

            // Required profile image
            $table->string('profile_image');

            // Password
            $table->string('password');
            $table->string('showpassword')->nullable();

            // Status and Role
            $table->enum('role', ['admin', 'user'])->default('user'); // admin, user
            $table->tinyInteger('status')->default(1); // 1 = Active, 0 = Inactive
            // Remember token

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
