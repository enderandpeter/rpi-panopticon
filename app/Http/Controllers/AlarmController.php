<?php

namespace App\Http\Controllers;

use App\Events\AlarmStatusChanged;
use App\Models\Alarm;
use App\Models\AlarmStatus;
use Illuminate\Http\Request;

class AlarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alarm $alarm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alarm $alarm)
    {
        $responseStatus = [];
        if($request->has('status')){
            if($alarm->pending_status){
                return [
                    'alarm' => $alarm->id,
                    'status' => 'pending'
                ];
            }

            $alarm->pending_status = true;
            $alarm->save();

            $newAlarmStatusRequest = $request->get('status');

            $newAlarmStatus = AlarmStatus::findOrFail($newAlarmStatusRequest);

            $alarm->status()->associate($newAlarmStatus);
            $alarm->save();

            AlarmStatusChanged::dispatch($alarm);

            $responseStatus = [
                'alarm' => $alarm->id,
                'status' => $alarm->status->name,
                'status_id' => $alarm->status->id
            ];
        }

        return $responseStatus;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alarm $alarm)
    {
        //
    }
}
