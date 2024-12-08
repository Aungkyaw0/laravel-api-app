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
        'status'
    ];

    protected $casts = [
        'operating_hours' => 'array'
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
