<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLogs;

class ActivityLogController extends Controller
{
    public function index()
{
    $logs = \App\Models\ActivityLogs::with('user')->latest()->paginate(20);
    return view('pages.activity_logs.index', compact('logs'));
}




}