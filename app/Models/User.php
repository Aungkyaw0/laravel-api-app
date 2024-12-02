<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
<<<<<<< HEAD
=======
use App\Models\Caregiver;
>>>>>>> bra

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
<<<<<<< HEAD
=======
        'role'
>>>>>>> bra
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function members(){
        return $this->hasMany(Member::class);
    }
<<<<<<< HEAD
=======

    public function caregivers(){
        return $this->hasMany(Caregiver::class);
    }

    public function partners(){
        return $this->hasMany(Partner::class);
    }

    public function volunteers(){
        return $this->hasMany(Volunteer::class);
    }
>>>>>>> bra
}
