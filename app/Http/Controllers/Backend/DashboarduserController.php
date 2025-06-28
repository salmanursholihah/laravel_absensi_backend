<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboarduserController extends Controller
{
       public function index()
   {

return view('pages.dashboard');
    
   }

}