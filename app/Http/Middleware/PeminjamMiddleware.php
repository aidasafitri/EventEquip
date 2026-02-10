<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PeminjamMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isPeminjam()) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
