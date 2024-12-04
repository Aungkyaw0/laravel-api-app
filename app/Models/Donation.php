<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'email',
        'phone',
        'amount',
        'payment_status',
        'payment_id',
        'payment_method',
        'message'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_status' => 'string'
    ];
} 