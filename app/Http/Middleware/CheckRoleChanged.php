<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::id();
            
            // Get current role from database
            $currentRole = DB::table('users')->where('id', $userId)->value('role');
            
            // Get role from session (stored when user logged in)
            $sessionRole = session('user_role');
            
            // If session role is not set, set it now
            if (!$sessionRole) {
                session(['user_role' => $currentRole]);
                return $next($request);
            }
            
            // If role has changed, show forced logout modal
            if ($sessionRole !== $currentRole) {
                // Don't allow any other page, force logout
                if ($request->path() !== 'logout') {
                    return response()->view('forced-logout', [
                        'oldRole' => $sessionRole,
                        'newRole' => $currentRole
                    ]);
                }
            }
        }
        
        return $next($request);
    }
}
