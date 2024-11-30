<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function user() {
        
        return $this->belongsTo(User::class);
    }
}
