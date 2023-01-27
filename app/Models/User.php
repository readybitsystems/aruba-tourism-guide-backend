<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Flagable, SoftDeletes;
    protected $hidden = [
        'password',
        'remember_token',
        'flags',
        'reset_token',
        'verification_code',
    ];

    protected $appends = [
        'active', 'profile_image'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //roles
    public const ROLE_USER  = 'user';
    public const ROLE_ADMIN = 'admin';

    //flags
    public const FLAG_ACTIVE         = 1;

    // Flagable methods
    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getProfileImageAttribute()
    {
        if ($this->user_profile) {

            return url('/') . '/public/assets/users/' . $this->id . '/' . $this->user_profile;
        }
        return null;
    }
}
