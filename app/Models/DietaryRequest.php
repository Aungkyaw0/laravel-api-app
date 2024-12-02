<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietaryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'caregiver_id',
        'current_dietary_requirement',
        'current_prefer_meal',
        'requested_dietary_requirement',
        'requested_prefer_meal',
        'reason',
        'additional_notes',
        'status'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function caregiver(): BelongsTo
    {
        return $this->belongsTo(Caregiver::class);
    }
} 