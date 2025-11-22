<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    // ============================
    // ADMIN LOGIN
    // ============================
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $admin = User::where('email', $request->email)
                     ->where('role', 'admin')
                     ->first();

        if (!$admin) {
            return response()->json([
                'status'  => false,
                'message' => 'Admin not found'
            ], 404);
        }

        if ($admin->status == 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Admin account inactive'
            ], 403);
        }

        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid password'
            ], 401);
        }

        $token = $admin->createToken('ADMIN_API_TOKEN')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Admin login successful',
            'token'   => $token,
            'user'    => $admin->makeHidden(['password'])
        ], 200);
    }

    // ============================
    // ADMIN LOGOUT
    // ============================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Admin logged out successfully'
        ], 200);
    }

    // ============================
    // ADMIN PROFILE
    // ============================
    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'admin'  => $request->user()->makeHidden(['password'])
        ], 200);
    }
}
