<?php

namespace App\Http\Controllers;
use App\Models\policy_applications;
use App\Models\ApprovedPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
// Store each file as zip
use Illuminate\Http\Request;

class ApplicationReviewController extends Controller
{
    //Display a list of all policy applications
    // This function retrieves all policy applications from the database and passes them to the view.
    public function index()
    {
        $applications = policy_applications::with(['user', 'policy'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $title = 'Policy Applications';
        $activePage = 'applications';
        $activeButton = 'laravel';
        $navName = 'Applications';
        
        return view('underwriter.applications.index', compact('applications', 'title', 'activePage', 'activeButton', 'navName'));
    }

    //show application details
    public function show($id)
    {
        $application = policy_applications::with(['user', 'policy'])
            ->findOrFail($id);
            
        $title = 'Application Details';
        $activePage = 'applications';
        $activeButton = 'laravel';
        $navName = 'Application Details';
        
        return view('underwriter.applications.show', compact('application', 'title', 'activePage', 'activeButton', 'navName'));
    }

    //Download application documents
    public function downloadDocuments($id)
    {
        $application = policy_applications::findOrFail($id);
        
        if (!$application->Requirements_path) {
            return back()->with('error', 'No documents are available for this application.');
        }
        
        if (Storage::exists($application->Requirements_path)) {
            return Storage::download($application->Requirements_path, 'application_' . $id . '_documents.zip');
        }
        
        return back()->with('error', 'The document file could not be found.');
    }

    //Approve an Application
    public function approve(Request $request, $id)
    {
        $application = policy_applications::findOrFail($id);
        
        // Check if already processed
        if ($application->Status !== 'pending') {
            return back()->with('error', 'This application has already been processed.');
        }
        
        $application->Status = 'accepted';
        $application->save();
        
        // Get policy details for expiration calculation
        $policy = $application->policy;
        
        // Calculate expiration date
        $approvalDate = Carbon::now();
        $durationDate = Carbon::parse($policy->Duration);
        $differenceInDays = $approvalDate->diffInDays($durationDate);
        $expiresAt = $approvalDate->copy()->addDays($differenceInDays);
        
        // Create approved policy record
        ApprovedPolicy::create([
            'User_ID' => $application->User_ID,
            'Policy_ID' => $application->Policy_ID,
            'expires_at' => $expiresAt,
            'Status' => 'active'
        ]);
        
        return redirect()->route('applications.index')->with('success', 'Application approved successfully. The policy has been created for the user.');
    }

    // Reject an application.

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $application = policy_applications::findOrFail($id);
        
        // Check if already processed
        if ($application->Status !== 'pending') {
            return back()->with('error', 'This application has already been processed.');
        }
        
        $application->Status = 'rejected';
        $application->notes = $application->notes . "\n\n             Rejection reason: " . $request->rejection_reason;
        $application->save();
        
        return redirect()->route('applications.index')->with('success', 'Application rejected successfully.');
    }
}
