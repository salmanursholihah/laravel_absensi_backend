<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkSchedule;
use App\Models\User;
use App\Notifications\ReminderCheckInNotification;

class WorkSchedulesController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('admin.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'dates' => 'required|array',
            'start_times' => 'required|array',
            'end_times' => 'required|array',
        ]);

        foreach ($request->dates as $i => $date) {
            WorkSchedule::create([
                'user_id' => $request->user_id,
                'date' => $date,
                'start_time' => $request->start_times[$i],
                'end_time' => $request->end_times[$i],
            ]);
        }

        // Ambil user yang ditugaskan jadwal
        $user = User::find($request->user_id);

        // Kirim notifikasi ke user tsb
        $user->notify(new ReminderCheckInNotification());

        return redirect()->route('work_schedules.index')
            ->with('success', 'Jadwal kerja 1 minggu berhasil disimpan & notifikasi dikirim.');
    }
}