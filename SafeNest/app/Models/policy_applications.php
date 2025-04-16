<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class policy_applications extends Model
{
  //  use HasFactory;

    protected $table = 'applications';

    protected $primaryKey = 'Application_ID';

    protected $fillable = [
        'User_ID', 'Policy_ID', 'Status','Requirements_path','notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'Policy_ID');
    }

    public function documents(){
        return $this->hasMany(policy_applications::class,'application_id');
    }
}
