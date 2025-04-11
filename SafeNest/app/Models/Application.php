<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
  //  use HasFactory;

    protected $table = 'applications';

    protected $primaryKey = 'Application_ID';

    protected $fillable = [
        'User_ID', 'Policy_ID', 'Status', 'Date_Applied'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'Policy_ID');
    }
}
