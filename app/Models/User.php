<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;  // <-- Add this
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;  // <-- Add HasApiTokens here

    protected $fillable = [
        'name','email','phone','address','city','pincode','profile_image','password','showpassword','role','status'
    ];

    protected $hidden = [
        'password','remember_token',
    ];
}
