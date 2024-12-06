<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberKitchenDistance extends Model
{
    protected $fillable = [
        'member_id',
        'food_service_id',
        'distance',
        'is_within_range'
    ];

    protected $casts = [
        'is_within_range' => 'boolean'
    ];
} 