<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Models\WorkSchedule;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function() {

            $now = now();

            Log::info('✅ Jadwal sedang berjalan di: ' . $now);

            $schedules = WorkSchedule::whereDate('date', $now->toDateString())->get();

            foreach ($schedules as $workSchedule) {

                // Jam masuk cocok
                if ($now->format('H:i') === substr($workSchedule->start_time, 0, 5)) {
                    $workSchedule->user->notify(new \App\Notifications\ReminderCheckInNotification);
                    Log::info('Notif masuk dikirim ke: ' . $workSchedule->user->name);
                }

                // Jam pulang cocok
                if ($now->format('H:i') === substr($workSchedule->end_time, 0, 5)) {
                    $workSchedule->user->notify(new \App\Notifications\ReminderCheckOutNotification);
                    Log::info('Notif pulang dikirim ke: ' . $workSchedule->user->name);
                }
            }

        })->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}