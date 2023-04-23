<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alarm extends Model
{
    use HasFactory;

    public function status(): BelongsTo {
        return $this->belongsTo(AlarmStatus::class, 'alarm_status_id');
    }
}
