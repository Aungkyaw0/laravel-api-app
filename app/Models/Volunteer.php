<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = ['name',
        'user_id', 'phone', 'address', 'emergency_contact', 
        'emergency_phone', 'has_vehicle', 'vehicle_type',
        'license_number', 'background_check_passed', 'status'
    ];

    protected $casts = [
        'has_vehicle' => 'boolean',
        'background_check_passed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilities()
    {
        return $this->hasMany(VolunteerAvailability::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
