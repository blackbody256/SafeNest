<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payments extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'policy_id',
        'approved_policy_id',
        'amount',
        'due_date',
        'payment_date',
        'status'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'datetime',
        'payment_date' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'policy_id', 'Policy_ID'); // custom key match
    }
    
    public function approvedPolicy()
    {
        return $this->belongsTo(ApprovedPolicy::class, 'approved_policy_id', 'Approved_Policy_ID');
    }
    
    // Update payment status based on due date
    public static function updatePaymentStatuses()
    {
        $today = Carbon::now();
        
        // Find all pending payments with due dates in the past
        return self::where('status', 'pending')
            ->where('due_date', '<', $today)
            ->update(['status' => 'overdue']);
    }
}