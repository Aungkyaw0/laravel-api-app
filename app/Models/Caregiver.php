<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caregiver extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'age',
        'gender',
        'location',
        'phone',
        'experience',
        'availability',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
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
}
