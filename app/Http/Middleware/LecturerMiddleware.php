<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LecturerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('user_shs')->check() && session('role') === 'Lecturer') {
            return $next($request);
        }

        return redirect('/SHS')->with('error', 'Unauthorized access.');
    }
}
