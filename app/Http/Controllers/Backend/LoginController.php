<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

protected function authenticated(Request $request, $user)
{
    $user = $user->fresh();

    Log::info('Role setelah fresh:', ['role' => $user->role]);

    if ($user->role === 'admin') {
        return redirect()->route('admin.home');
    }

    return redirect()->route('user.home');
}
}