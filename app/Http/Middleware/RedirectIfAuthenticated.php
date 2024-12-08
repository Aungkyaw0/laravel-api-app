<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                switch ($user->role) {
                    case 'member':
                        return redirect()->route('member.dashboard');
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'caregiver':
                        return redirect()->route('caregiver.dashboard');
                    case 'partner':
                        return redirect()->route('partner.dashboard');
                    case 'volunteer':
                        return redirect()->route('volunteer.dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
} 