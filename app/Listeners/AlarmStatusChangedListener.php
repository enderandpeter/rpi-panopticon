<?php

namespace App\Listeners;

use App\Events\AlarmStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AlarmStatusChangedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AlarmStatusChanged $event): void
    {
        $event->alarm->pending_status = false;
        $event->alarm->save();
    }
}
