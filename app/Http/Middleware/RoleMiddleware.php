<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Penggunaan: ->middleware('role:admin') atau ->middleware('role:user')
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Jika user mencoba akses area admin → redirect ke user.home
            if (Auth::user()->role === 'user') {
                return redirect()->route('user.home')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Jika admin mencoba akses area user → redirect ke dashboard
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}