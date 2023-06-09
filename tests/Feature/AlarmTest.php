<?php

namespace Tests\Feature;

use App\Events\AlarmStatusChanged;
use App\Listeners\AlarmStatusChangedListener;
use App\Models\Alarm;
use App\Models\AlarmStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AlarmTest extends TestCase
{
    use RefreshDatabase;
    /**
     * The site acknowledges setting the alarm
     */
    public function test_can_set_alarm_status(): void
    {
        $this->seed();
        Event::fake();

        $alarm = Alarm::first();
        $alarmStatus = AlarmStatus::all()->get(1);

        $response = $this->putJson(route('alarms.update', ['alarm' => $alarm->id]), [
            'status' => $alarmStatus->id,
        ]);

        $response->assertStatus(200);

        $alarm->refresh();
        $this->assertEquals($alarmStatus->id, $alarm->status->id);

        Event::assertDispatched(AlarmStatusChanged::class);
    }

    public function test_has_arming_prereq(): void {
        $this->seed();

        $alarm = Alarm::first();

        $response = $this->putJson(route('alarms.update', ['alarm' => $alarm->id]), [
            'status' => 'arming',
        ]);

        $response->assertStatus(409);
    }

    public function test_has_armed_prereq(): void {
        $this->seed();

        $alarm = Alarm::first();

        $response = $this->putJson(route('alarms.update', ['alarm' => $alarm->id]), [
            'status' => 'armed',
        ]);

        $response->assertStatus(409);
    }

    public function test_sets_error_for_non_existing_alarm(): void
    {
        $this->seed();
        Event::fake();

        $alarmStatus = AlarmStatus::all()->get(1);

        $response = $this->putJson(route('alarms.update', ['alarm' => 50]), [
            'status' => $alarmStatus->id,
        ]);

        $response->assertNotFound();
        Event::assertNotDispatched(AlarmStatusChanged::class);
    }

    public function test_sets_error_for_non_existing_status(): void
    {
        $this->seed();
        Event::fake();

        $alarm = Alarm::first();

        $response = $this->putJson(route('alarms.update', ['alarm' => $alarm->id]), [
            'status' => 50,
        ]);

        $response->assertNotFound();
        Event::assertNotDispatched(AlarmStatusChanged::class);
    }
}
