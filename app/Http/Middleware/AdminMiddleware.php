<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
// AdminMiddleware
public function handle(Request $request, Closure $next): Response
{
    if (!auth('web')->check() || auth('web')->user()->role !== 'admin') {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Access Denied: Admins Only'
            ], 403);
        }
        return redirect()->route('admin.dashboard'); // browser ke liye
    }
    return $next($request);
}
}
