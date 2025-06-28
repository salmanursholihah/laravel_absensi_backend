<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle($request, Closure $next, $role)
    // {
    //     if (Auth::check() && Auth::user()->role === $role) {
    //         return $next($request);
    //     }

    //     abort(403, 'Unauthorized');
    // }
//     public function handle($request, Closure $next, $role)
// {
//     Log::info('Role user:', ['actual' => Auth::user()->role ?? 'null', 'expected' => $role]);

//     if (Auth::check() && Auth::user()->role === $role) {
//         return $next($request);
//     }

//     abort(403, 'Unauthorized');
// }



public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);

}
}