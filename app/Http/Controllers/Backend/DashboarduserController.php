<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboarduserController extends Controller
{
       public function index()
   {

return view('pages.dashboard');
    
   }

}