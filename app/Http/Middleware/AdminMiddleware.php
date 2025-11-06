<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu');
        }

        if (Auth::user()->role !== 'admin') {
            // Redirect ke dashboard sesuai role, bukan ke home
            $user = Auth::user();
            
            if ($user->role === 'kasir') {
                return redirect()->route('kasir.dashboard');
            }
            
            // Member atau role lainnya redirect ke home tanpa error message
            return redirect('/');
        }

        return $next($request);
    }
}
