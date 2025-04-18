<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
//use App\Http\Controller\DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
//use Carbon\Carbon;



use App\Models\ApprovedPolicy;
use Carbon\Carbon;
use App\Models\policy_applications;


class ApplicationController extends Controller
{
    // public function index()
    // {
    //     $applications = Application::with('user', 'policy')->get();

    //     return view('underwriter.applications.index', compact('applications'));
    // }
    public function index()
{
    $applications = Application::with(['user', 'policy'])->get();
    return view('underwriter.applications.index', [
        'applications' => $applications,
        'title' => 'Approve Policies',
        'activePage' => 'applications', 
        'activeButton' => 'laravel',
        'navName' => 'Approve Policies'
    ]);
}

// Inside ApplicationController.php (or wherever you're handling the approval logic)
// public function approve(Application $application)
// {
//     // Check if the policy has already been approved to prevent duplicates
//     $alreadyApproved = ApprovedPolicy::where('policy_id', $application->Policy_ID)
//                                      ->where('user_id', $application->user->id)
//                                      ->exists();

//     if ($alreadyApproved) {
//         return back()->with('error', 'This policy is already approved.');
//     }

//     // Get the policy associated with the application
//     $policy = $application->policy;

//     // Calculate the expiry date (current date + policy duration in years)
//     $expiryDate = Carbon::now()->addYears($policy->duration);

//     // Start the transaction to ensure database consistency
//     DB::beginTransaction();

//     try {
//         // Update the application status to "Approved"
//         $application->status = 'Approved';
//         $application->save();

//         // Insert the record into approved_policies table
//         DB::table('approved_policies')->insert([
//             'user_id' => $application->user->id,
//             'Policy_ID' => $application->Policy_ID,
//             'expiry_date' => $expiryDate->toDateString(),
//             'status' => 'active',  // Status is active when approved
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Commit the transaction
//         DB::commit();

//         return redirect()->route('approved-policies.index')->with('success', 'Policy approved successfully!');
//     } catch (\Exception $e) {
//         // Rollback the transaction in case of error
//         DB::rollBack();
//         return back()->with('error', 'Error approving the policy: ' . $e->getMessage());
//     }
// }



public function approve($id)
{
    try {
        $application = Application::with(['user', 'policy'])->findOrFail($id);
        Log::info('Approving Application: ', ['application' => $application]);

        $user = $application->user;
        $policy = $application->policy;

        Log::info('Associated User: ', ['user' => $user]);
        Log::info('Associated Policy: ', ['policy' => $policy]);

        // Make sure Duration is correctly treated as an integer
        $durationYears = (int)$policy->Duration;

        $approvalDate = Carbon::now();
        $expiryDate = $approvalDate->copy()->addYears($durationYears);

        //$expiryDate = now()->addYears($policy->Duration);  // Add the duration in years to the current date

 
 
        // Save Approved Policy
        ApprovedPolicy::create([
            'user_id' => $user->id,
            'Policy_ID' => $policy->Policy_ID, // make sure this matches your DB column name exactly!
            'Expiry_Date' => $expiryDate,
            'Status' => 'Active',
            'created_at' => $approvalDate,
            'updated_at' => $approvalDate,
        ]);

        // Update application status
        $application->update(['Status' => 'Approved']);

        return back()->with('success', 'Policy approved successfully.');

    } catch (\Exception $e) {
        Log::error('Approval failed: ' . $e->getMessage());
        return back()->with('error', 'Policy approval failed.');
    }
}





    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->Status = 'Rejected';
        $application->save();

        return redirect()->route('applications.index')->with('success', 'Policy rejected successfully.');
    }

    //customer dashboard
        public function customerApplications()
    {
        // Get only the applications of the logged-in customer (user)
        $userId = auth()->id();

        $applications = \App\Models\policy_applications::where('User_ID', $userId)
                        ->with('policy')
                        ->get();

        return view('customer.dashboard', [
            'applications' => $applications,
            'title' => 'Dashboard', 
            'activePage' => 'dashboard', 
            'activeButton' => 'dashboard', 
            'navName' => 'Dashboard'
        ]);
    }

}

