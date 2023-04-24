<?php

namespace App\Http\Controllers;

use App\Events\AlarmStatusChanged;
use App\Http\Resources\AlarmResource;
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
        return new AlarmResource($alarm);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alarm $alarm)
    {
        $responseStatus = [];
        if($request->has('status')){
            $newAlarmStatusRequest = $request->get('status');

            if(is_numeric($newAlarmStatusRequest)){
                $newAlarmStatus = AlarmStatus::findOrFail($newAlarmStatusRequest);
            } else {
                $newAlarmStatus = AlarmStatus::where('name', $newAlarmStatusRequest)->firstOrFail();
            }

            if($newAlarmStatus->name === 'arming'){
                if($alarm->status->name !== 'initialized'){
                    return response([
                        'status' => $alarm->status->name,
                        'message' => "Alarm must be initialized before setting to $newAlarmStatus->name"
                    ], 409);
                }
            }

            if($newAlarmStatus->name === 'armed'){
                if(!($alarm->status->name === 'arming' || $alarm->status->name === 'recording')){
                    return response([
                        'status' => $alarm->status->name,
                        'message' => "Alarm must be armed or recording before setting to $newAlarmStatus->name"
                    ], 409);
                }
            }

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
