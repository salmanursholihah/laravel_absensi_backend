<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users= User::where('role','user')->get('index');
        return view('user.index', compact ('user'));
        
        
    }
}