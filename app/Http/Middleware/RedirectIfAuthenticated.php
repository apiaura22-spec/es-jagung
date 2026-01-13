<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                // --- KODE KOREKSI KRITIS DIMULAI DI SINI ---
                
                // Jika pengguna sudah login, tentukan dashboard yang sesuai berdasarkan role
                if (Auth::check()) {
                    if (Auth::user()->role === 'admin') {
                        // Arahkan admin ke dashboard admin
                        return redirect()->route('admin.dashboard');
                    }
                    // Arahkan user biasa ke dashboard user
                    return redirect()->route('user.dashboard');
                }
                
                // --- KODE KOREKSI KRITIS BERAKHIR DI SINI ---
                
                // Fallback default Laravel (jika kodenya dimodifikasi)
                // return redirect(RouteServiceProvider::HOME); 
            }
        }

        return $next($request);
    }
}
