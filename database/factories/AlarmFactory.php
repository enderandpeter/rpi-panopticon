<?php

namespace Database\Factories;

use App\Models\AlarmStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alarm>
 */
class AlarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Main',
            'alarm_status_id' => AlarmStatus::factory(),
        ];
    }
}
