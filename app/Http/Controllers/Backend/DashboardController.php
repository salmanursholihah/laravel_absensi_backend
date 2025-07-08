<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Company;

class DashboardController extends Controller
{
   public function index()
   {
$users = User::all();
$catatan = Catatan::all();
$attendance = Attendance::all();
$company = Company::all();

return view('pages.dashboard',compact('users','catatan','company','attendance'));
    
   }
}