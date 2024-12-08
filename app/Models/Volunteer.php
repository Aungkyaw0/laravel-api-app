<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Volunteer extends Model
{
    protected $fillable = ['name',
        'user_id', 'phone', 'address', 'emergency_contact', 
        'emergency_phone', 'has_vehicle', 'vehicle_type',
        'license_number', 'status'
    ];

    protected $casts = [
        'has_vehicle' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
