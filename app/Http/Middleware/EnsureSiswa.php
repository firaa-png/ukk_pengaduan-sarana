<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSiswa
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('siswa_id')) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
