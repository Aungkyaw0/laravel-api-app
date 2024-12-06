<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerAvailability extends Model
{
    protected $fillable = [
        'volunteer_id',
        'day_of_week',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
} 