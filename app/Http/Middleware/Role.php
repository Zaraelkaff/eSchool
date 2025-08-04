<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak: Role tidak diizinkan.');
        }

        return $next($request);
    }
}
