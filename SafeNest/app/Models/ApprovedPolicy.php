<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApprovedPolicy extends Model
{
    use HasFactory;

    protected $primaryKey = 'Approved_Policy_ID';
    
    protected $fillable = [
        'User_ID',
        'Policy_ID',
        'expires_at',
        'Status'  // Corrected from 'status' to match your database schema
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'Policy_ID');
    }
    
    // Update the status based on expiration date
    public function updateStatus()
    {
        if ($this->expires_at && Carbon::now()->greaterThan($this->expires_at)) {
            $this->Status = 'expired';
            $this->save();
        }
    }
    
    // Remove the misplaced userPolicies method from here
}