<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Caregiver;

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
        'role'
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

    public function caregivers(){
        return $this->hasMany(Caregiver::class);
    }

    public function partners(){
        return $this->hasMany(Partner::class);
    }

    public function volunteers(){
        return $this->hasMany(Volunteer::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function caregiver()
    {
        return $this->hasOne(Caregiver::class);
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function getRoleAttribute()
    {
        if ($this->partner()->exists()) return 'partner';
        if ($this->caregiver()->exists()) return 'caregiver';
        if ($this->member()->exists()) return 'member';
        if ($this->volunteer()->exists()) return 'volunteer';
        if ($this->admin()->exists()) return 'admin';
        return 'user';
    }
}
