<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

public function showLoginForm()
{
return view('admin.login');
}

public function login(Request $request)
{
$credentials = $request->only('email', 'password');

if (Auth::guard('admin')->attempt($credentials)) {
return redirect()->route('admin.home');
}

return back()->withErrors(['email' => 'Login gagal!']);
}
}