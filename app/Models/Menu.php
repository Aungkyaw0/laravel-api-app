<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'caregiver_id',
        'partner_id',
        'meal_type',
        'description',
        'available_date',
        'menu_items',
        'status'
    ];

    protected $casts = [
        'menu_items' => 'array',
        'available_date' => 'date',
        'meal_type' => 'string',
        'status' => 'string'
    ];

    public function caregiver(): BelongsTo
    {
        return $this->belongsTo(Caregiver::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'menu_meals')
                    ->withTimestamps();
    }

    public function mealPlans(): HasMany
    {
        return $this->hasMany(MealPlan::class);
    }
} 