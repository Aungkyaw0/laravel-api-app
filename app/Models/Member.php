<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Member extends Model
{

    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;
    
>>>>>>> bra
    protected $fillable = [
        'name',
        'gender',
        'location',
        'phone',
        'dietary_requirement',
        'prefer_meal',
    ];
<<<<<<< HEAD
 
    public function user() {
        
        return $this->belongsTo(User::class);
    }
=======

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
>>>>>>> bra
}
