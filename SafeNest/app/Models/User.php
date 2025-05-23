<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


        // Relationship with Underwriter
        public function underwriter()
        {
            return $this->hasOne(Underwriter::class);
        }
    
        // Helper methods
        public function isAdmin()
        {
            return $this->role === 'admin';
        }
    
        public function isUnderwriter()
        {
            return $this->role === 'underwriter' && $this->underwriter;
        }
        public function getCommissionRateAttribute()
    {
        return $this->underwriter ? $this->underwriter->commission_rate : null;
    }
        public function isCustomer()
        {
            return $this->role === 'customer';
        }

    public function approvedPolicies()
    {
        return $this->hasMany(ApprovedPolicy::class, 'User_ID');
    }

}

