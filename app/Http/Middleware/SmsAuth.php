<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsAuth
{
    /**
     * Handle an incoming request.
     * Checks if user is authenticated via SMS session
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('sms_user_id')) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the School Management System.');
        }

        return $next($request);
    }
}

