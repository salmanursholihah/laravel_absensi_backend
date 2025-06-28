<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
public function showLoginForm()
{
return view('pages.auth.admin-login'); // Buat blade ini nanti
}

public function login(Request $request)
{
$credentials = $request->only('email', 'password');

if (Auth::guard('admin')->attempt($credentials)) {
return redirect()->intended('/admin/dashboard');
}

return back()->withErrors([
'email' => 'Login admin gagal.',
]);
}

public function logout()
{
Auth::guard('admin')->logout();
return redirect('/admin/login');
}
}