<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('home'); // atau route admin sesuai kamu
        }

        return redirect()->route('user.zpublic.index'); // atau route user sesuai kamu
    }
}