<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class MealPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'caregiver_id',
        'menu_id',
        'partner_id',
        'deliver_meal_type',
        'meal_date',
        'dietary_category',
        'is_general',
        'status'
    ];

    protected $casts = [
        'meal_date' => 'datetime',
        'is_general' => 'boolean'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function caregiver(): BelongsTo
    {
        return $this->belongsTo(Caregiver::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_plan_meals');
        // Assuming you have a pivot table named 'meal_plan_meals'
    }
}
