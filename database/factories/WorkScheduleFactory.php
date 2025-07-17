<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\WorkSchedule;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkSchedule>
 */
class WorkScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    protected $model = WorkSchedule::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->date(),
            'start_time' => '08:00',
            'end_time' => '17:00',
        ];
    }
}