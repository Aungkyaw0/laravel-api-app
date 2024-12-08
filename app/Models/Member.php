<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\MemberKitchenDistance;
class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address',
        'dietary_requirement',
        'prefer_meal',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'is_within_delivery_range' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dietaryRequests(): HasMany
    {
        return $this->hasMany(DietaryRequest::class);
    }

    public function mealPlans(): HasMany
    {
        return $this->hasMany(MealPlan::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function preferredKitchen()
    {
        return $this->belongsTo(FoodService::class, 'preferred_kitchen_id');
    }
}
