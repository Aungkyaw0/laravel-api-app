<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'caregiver_id',
        'menu_id',
        'meal_type',
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

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}