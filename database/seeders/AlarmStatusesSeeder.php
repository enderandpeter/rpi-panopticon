<?php

namespace Database\Seeders;

use App\Models\AlarmStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlarmStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlarmStatus::firstOrCreate([
            'name' => 'disabled'
        ]);

        AlarmStatus::firstOrCreate([
            'name' => 'initialized'
        ]);

        AlarmStatus::firstOrCreate([
            'name' => 'armed'
        ]);
        AlarmStatus::firstOrCreate([
            'name' => 'recording'
        ]);

    }
}
