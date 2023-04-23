<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlarmStatus extends Model
{
    use HasFactory;

    public function alarms(): HasMany {
        return $this->hasMany(Alarm::class);
    }
}
