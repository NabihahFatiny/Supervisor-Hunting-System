<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('user_shs')->check() || session('role') !== 'Student') {
            return redirect('/SHS')->with('error', 'Please login as a student to access this page.');
        }

        return $next($request);
    }
}
