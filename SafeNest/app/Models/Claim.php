<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;


    protected $table = 'claims'; 

    protected $primaryKey = 'Claim_ID';


    protected $fillable = [
        'user_id',
        'Policy_ID',
        'Description',
        'Status',
        'attachment',


    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'Policy_ID','Policy_ID');
    }
}
