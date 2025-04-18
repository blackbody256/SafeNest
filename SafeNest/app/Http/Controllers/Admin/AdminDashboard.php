<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Policy;
use App\Models\Claim;
use App\Http\Controllers\Controller;
use App\Models\ApprovedPolicy;

class AdminDashboard extends Controller
{
    
    public function index()
    {
        $userCount = User::where('role','customer')->count();
        $policyCount = ApprovedPolicy::where('status', 'active')->count(); // adjust status filter as needed
        $claimCount = Claim::where('status', 'pending')->count(); // same here

        return view(
            'admin.admindashboard',[
            'userCount' => $userCount,
            'policyCount' => $policyCount,
            'claimCount' => $claimCount,
            ]
        );
    }
}