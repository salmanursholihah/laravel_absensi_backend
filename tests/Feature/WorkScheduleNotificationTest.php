 <?php

// namespace Tests\Feature;

// use App\Models\User;
// use App\Models\WorkSchedule;
// use App\Notifications\ReminderCheckInNotification;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;
// use Illuminate\Support\Facades\Notification;

// class WorkScheduleNotificationTest extends TestCase
// {
//     use RefreshDatabase;

//     /** @test */
//     public function admin_can_create_work_schedule_and_send_notification()
//     {
//         // Nonaktifkan kirim nyata
//         Notification::fake();

//         // Buat user palsu
//         $user = User::factory()->create();

//         // Buat WorkSchedule manual
//         $schedule = WorkSchedule::factory()->create([
//             'user_id' => $user->id,
//             'date' => now()->format('Y-m-d'),
//             'start_time' => '08:00',
//             'end_time' => '17:00',
//         ]);

//         // Kirim notifikasi (simulate yang kamu lakukan di Controller)
//         $user->notify(new ReminderCheckInNotification());

//         // Cek notifikasi beneran terkirim
//         Notification::assertSentTo(
//             [$user],
//             ReminderCheckInNotification::class
//         );

//         // Pastikan WorkSchedule memang ada di DB
//         $this->assertDatabaseHas('work_schedules', [
//             'id' => $schedule->id,
//             'user_id' => $user->id,
//         ]);
//     }
// }