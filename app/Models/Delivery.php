<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'volunteer_id', 'pickup_address', 'delivery_address',
        'pickup_time', 'delivery_time', 'meal_type', 'status',
        'distance', 'route_details'
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
        'delivery_time' => 'datetime',
        'route_details' => 'array',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
} 