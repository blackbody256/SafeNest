<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedPolicy extends Model
{
    use HasFactory;
    protected $primaryKey = 'Approved_policy_ID'; 
     
    protected $fillable = [
        'user_id',
        'Policy_ID',
       // 'approved_date',
        'Expiry_Date',
        'Status'
    ];

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
    
    public function policy()
    {
    return $this->belongsTo(Policy::class, 'Policy_ID');
    }
}
