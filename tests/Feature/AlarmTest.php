<?php

namespace Tests\Feature;

use App\Events\AlarmStatusChanged;
use App\Listeners\AlarmStatusChangedListener;
use App\Models\Alarm;
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

        $response = $this->putJson(route('alarms.update', ['alarm' => $alarm->id]), [
            'status' => 2,
        ]);

        $response->assertStatus(200);

        $alarm->refresh();
        $this->assertEquals(2, $alarm->status->id);

        Event::assertDispatched(AlarmStatusChanged::class);
        Event::assertListening(AlarmStatusChanged::class, AlarmStatusChangedListener::class);
    }

    public function test_sets_error_for_non_existing_alarm(): void
    {
        $this->seed();
        Event::fake();

        $response = $this->putJson(route('alarms.update', ['alarm' => 50]), [
            'status' => 2,
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
