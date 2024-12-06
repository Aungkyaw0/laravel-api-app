<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            return redirect()->route('login')
                ->with('error', 'Unauthorized access. Please login with correct credentials.');
        }

        return $next($request);
    }
}
