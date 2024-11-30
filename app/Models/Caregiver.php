<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caregiver extends Model
{
     /** @use HasFactory<\Database\Factories\MemberFactory> */
     use HasFactory;
     protected $fillable = [
        'name',
        'age',
        'gender',
        'location',
        'phone',
        'experience',
        'availability', // Assuming 'availability' is a string like 'Part-time' or 'Full-time'
    ];
  
    public function user() {
         
         return $this->belongsTo(User::class);
    }
}
