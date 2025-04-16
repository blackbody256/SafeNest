<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $table = 'policies';
    protected $primaryKey = 'Policy_ID';

    protected $fillable = [
        'Title',
        'Description',
        'Premium',
        'Duration',
    ];

    public function applications()
    {
    return $this->hasMany(Application::class, 'Policy_ID');
     }

     public function approvedPolicies()
    {
        return $this->hasMany(ApprovedPolicy::class, 'Policy_ID');
    }

}
