<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
public function showRegisterForm()
{
return view('pages.auth.auth-register');
}

public function register(Request $request)
{
$validated = $request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users,email',
'password' => 'required|string|min:6|confirmed',
]);

$user = User::create([
'name' => $validated['name'],
'email' => $validated['email'],
'password' => bcrypt($validated['password']),
'role' => 'user', // sesuaikan jika kamu pakai role lain
]);

Auth::login($user); // langsung login setelah register
return redirect()->route('home');
}



}