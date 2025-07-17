<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Notifications\ReminderCheckInNotification;
use Illuminate\Support\Facades\Notification; 

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_sent()
    {
        Notification::fake(); 

        $user = User::factory()->create();

        $user->notify(new ReminderCheckInNotification());

        Notification::assertSentTo(
            [$user],
            ReminderCheckInNotification::class
        );
    }
}