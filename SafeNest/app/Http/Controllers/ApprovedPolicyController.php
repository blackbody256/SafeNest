<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApprovedPolicy;
use App\Models\Application;
use Carbon\Carbon;
use App\Models\Policy;

class ApprovedPolicyController extends Controller
{
      // Inside ApprovedPolicyController.php
public function index()
{
    // Fetch approved policies along with related policy and user details
    $approvedPolicies = ApprovedPolicy::with(['policy', 'user'])->get();

    return view('underwriter.approvedpolicies.index', [
        'approvedPolicies' => $approvedPolicies,
        'title' => 'Approved Policies',
        'activePage' => 'approved-policies',
        'activeButton' => 'approved',
        'navName' => 'Approved Policies'
    ]);
}


    // Store approved policy based on an application
    public function store(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);
        $policy = Policy::findOrFail($application->Policy_ID);
    
        // Get duration in years (assuming policy duration is saved as an integer like 5 for 5 years)
        $durationYears = (int) $policy->duration;
    
        // Calculate approved date and expiry date
        $approvedDate = Carbon::now();
        $expiryDate = $approvedDate->copy()->addYears($durationYears);
    
        // Create new approved policy
        $approvedPolicy = new ApprovedPolicy();
        $approvedPolicy->user_id = $application->user_id;  // Set user_id from the application
        $approvedPolicy->Policy_ID = $policy->id;          // Set policy_id from the policy
        $approvedPolicy->Expiry_Date = $expiryDate;
        $approvedPolicy->Status = 'Active'; 
        
        dd($approvedPolicy);// Set status as active
        $approvedPolicy->save();
    
        // Update the application status to 'Approved'
        $application->status = 'Approved';
        $application->save();
    
        return redirect()->route('approvedpolicies.index')->with('success', 'Policy approved and recorded successfully.');
    }
    

    // Inside your controller where you want to update expired policies
public function updateExpiredPolicies()
{
    $expiredPolicies = ApprovedPolicy::where('status', 'active')
                                     ->where('expiry_date', '<', now())
                                     ->get();

    foreach ($expiredPolicies as $policy) {
        $policy->status = 'expired';
        $policy->save();
    }

    return back()->with('success', 'Expired policies updated!');
}

}
