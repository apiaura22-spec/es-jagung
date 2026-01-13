<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Redirect default ke dashboard user jika role tidak sesuai
            return redirect()->route('user.dashboard');
        }
        return $next($request);
    }
}
