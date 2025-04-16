<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $primaryKey = 'Quotes_ID';
    
    protected $fillable = ['user_id', 'Policy_ID', 'Description', 'Amount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'Policy_ID');
    }
}
