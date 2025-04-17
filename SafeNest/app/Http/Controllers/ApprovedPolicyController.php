<?php

namespace App\Http\Controllers;
use App\Models\ApprovedPolicy;
use App\Models\Policy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApprovedPolicyController extends Controller
{
    /**
     * Approve a policy for a user
     */
    public function approve(Request $request)
    {
        $request->validate([
            'User_ID' => 'required|exists:users,id',
            'Policy_ID' => 'required|exists:policies,Policy_ID',
        ]);

        // Get the policy to calculate expiration date
        $policy = Policy::findOrFail($request->Policy_ID);
        
        // Calculate expiration date based on policy duration
        $approvalDate = Carbon::now();
        
        // Instead of parsing Duration as a date, use it as months
        // Try to extract numeric value if it's stored as string
        $durationValue = 12; // Default to 12 months
        
        if (is_numeric($policy->Duration)) {
            $durationValue = (int)$policy->Duration;
        }
        
        $expiresAt = $approvalDate->copy()->addMonths($durationValue);
        
        // Create the approved policy with calculated expiration
        $approvedPolicy = ApprovedPolicy::create([
            'User_ID' => $request->User_ID,
            'Policy_ID' => $request->Policy_ID,
            'expires_at' => $expiresAt,
            'Status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Policy approved successfully.');
    }
    
    /**
     * Update status for all policies
     */
    public function updateStatuses()
    {
        $approvedPolicies = ApprovedPolicy::all();
        foreach ($approvedPolicies as $policy) {
            $policy->updateStatus();
        }
        
        return redirect()->back()->with('success', 'Policy statuses updated.');
    }

    /**
     * Display user policies
     */
    public function userPolicies()
    {
        // Get authenticated user ID
        $userId = auth()->id();
        
        // Eager load the policy relationship to avoid N+1 queries
        $approvedPolicies = ApprovedPolicy::with('policy')
            ->where('User_ID', $userId)
            ->get();
        
        // Update status for displayed policies
        foreach ($approvedPolicies as $policy) {
            $policy->updateStatus();
        }
        
        // Pass variable to view
        return view('customer.mypolicy', compact('approvedPolicies'));
    }

    /**
     * Display a listing of approved policies
     */
    public function index()
    {
        // Get all approved policies with their relationships
        $approvedPolicies = ApprovedPolicy::with(['user', 'policy'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Update status for displayed policies
        foreach ($approvedPolicies as $policy) {
            $policy->updateStatus();
        }
        
        return view('underwriter.approvedpolicies.index', [
            'approvedPolicies' => $approvedPolicies,
            'title' => 'Approved Policies',
            'activePage' => 'approvedpolicies',
            'activeButton' => 'laravel',
            'navName' => 'Approved Policies'
        ]);
    }
}

