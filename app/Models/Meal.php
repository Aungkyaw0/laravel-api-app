<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'food_service_id',
        'name',
        'description',
        'ingredients',
        'nutritional_info',
        'meal_type',
        'dietary_flags',
        'is_available'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'nutritional_info' => 'array',
        'dietary_flags' => 'array'
    ];

    public function foodService()
    {
        return $this->belongsTo(FoodService::class);
    }
}
