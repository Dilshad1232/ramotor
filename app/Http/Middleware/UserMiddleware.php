<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('web')->check() || auth('web')->user()->role !== 'user') {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Access Denied: Users Only'
                ], 403);
            }
            return redirect()->route('user.dashboard'); // already logged in? dashboard
        }
        return $next($request);
    }

}
