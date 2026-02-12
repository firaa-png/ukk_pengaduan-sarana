<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAuthenticatedOrSiswa
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // allow if admin logged in via Auth
        if (Auth::check()) {
            return $next($request);
        }

        // allow if siswa logged in via session
        if ($request->session()->has('siswa_id')) {
            return $next($request);
        }

        // otherwise redirect to login
        return redirect()->route('login');
    }
}
