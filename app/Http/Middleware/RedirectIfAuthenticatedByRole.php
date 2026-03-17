<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedByRole
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard('regular')->check()) {
            return redirect()->route('regular.dashboard');
        }

        if (Auth::guard('ong')->check()) {
            return redirect()->route('ong.dashboard');
        }

        return $next($request);
    }
}