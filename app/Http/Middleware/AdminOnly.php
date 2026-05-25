<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $user = session('user');

        if ($user['role'] !== 'admin') {
            return redirect('/staff/dashboard')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}