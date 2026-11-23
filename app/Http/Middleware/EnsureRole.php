<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        if (!$user || !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return to_route('login')->withErrors(['email' => 'Silakan masuk dengan akun aktif.']);
        }
        abort_unless(in_array($user->role, $roles, true), 403);
        return $next($request);
    }
}
