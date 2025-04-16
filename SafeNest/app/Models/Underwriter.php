<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Underwriter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commission_rate'
    ];

    protected $attributes = [
        'commission_rate' => 5.00
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
