<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $roles): Response
    // {
    //      if (!Auth::check()) {
    //         return redirect('/login');
    //     }

    //     if (!in_array(Auth::user()->role, $roles)) {
    //         abort(403, 'Unauthorized');
    //     }
    //     return $next($request);
    // }

//     public function handle(Request $request, Closure $next, $roles)
// {
//     if (!auth()->check()) {
//         return redirect('/login');
//     }

//     // Ubah string 'admin,user' jadi array ['admin', 'user']
//     $rolesArray = explode(',', $roles);
//     if (!in_array(auth()->user()->role, $rolesArray)) {
//         abort(403, 'Unauthorized.');
//     }

//     return $next($request);
// }
public function handle($request, Closure $next, $roles)
{
    if (auth()->check()) {
        $user = auth()->user();
        // dd($user); // Pastikan user terautentikasi & role TIDAK kosong.

    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);


    }

    abort(403, 'Role not matched or not authenticated');
}
}