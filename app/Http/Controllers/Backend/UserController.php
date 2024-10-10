<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
       //index
       public function index()
       {
           //search by name, pagination 10
           $users = User::where('name', 'like', '%' . request('name') . '%')
               ->orderBy('id', 'desc')
               ->paginate(10);
           return view('pages.users.index', compact('users'));
       }
}
