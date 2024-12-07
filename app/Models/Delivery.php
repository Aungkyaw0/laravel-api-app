<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'volunteer_id', 'partner_id', 'meal_plan_id', 'pickup_address', 'delivery_address',
        'pickup_time', 'delivery_time', 'meal_type', 'status',
        'distance', 'route_details', 'rejection_reason',
        'member_confirmation', 'member_confirmation_time', 'delivery_notes'
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
        'delivery_time' => 'datetime',
        'route_details' => 'array',
        'member_confirmation' => 'boolean',
        'member_confirmation_time' => 'datetime',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }
} 