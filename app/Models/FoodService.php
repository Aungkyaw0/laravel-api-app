<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodService extends Model
{
    protected $fillable = [
        'partner_id',
        'service_name',
        'description',
        'cuisine_type',
        'service_area',
        'operating_hours',
        'status',
        'food_safety_certified',
        'last_inspection_date',
        'safety_rating',
        'safety_procedures'
    ];

    protected $casts = [
        'operating_hours' => 'array',
        'safety_procedures' => 'array',
        'food_safety_certified' => 'boolean',
        'last_inspection_date' => 'date'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
