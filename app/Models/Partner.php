<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Partner extends Model
{
    protected $fillable = [
        'name',
        'company_name',
        'company_email',
        'phone',
        'location',
        'country',
        'business_type',
        'service_offer',
        'latitude',
        'longitude'
    ];

    public function user() {
        
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function mealPlans(): HasMany
    {
        return $this->hasMany(MealPlan::class);
    }
    public function foodServices(): HasMany
    {
        return $this->hasMany(FoodService::class);
    }
}
