<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\policy_applications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Str;

class PolicyCatalogueController extends Controller
{
    //Display the policy catalogue
    public function index(){
        $policies = Policy::all();
        $title = "Policy Catalogue";
        $activePage = 'catalogue';
        $activeButton = 'laravel';
        $navName = 'Policy Catalogue';

        return view('customer.policy_catalogue', compact('policies', 'title', 'activePage', 'activeButton', 'navName'));
    }


    // Displaying the application form for a specific policy
    public function showApplicationForm($id){
        $policy = Policy::findOrFail($id);
        $title = "Apply for Policy";
        $activePage = 'catalogue';
        $activeButton = 'laravel';
        $navName = 'Policy Application';

        return view('customer.policy_application', compact('policy', 'title', 'activePage', 'activeButton','navName'));
    }

    //Store a new policy application info
    public function submitApplication(Request $request, $id){
        $policy = Policy::findOrFail($id);
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);
        // Create directory for this application
        $userId = auth()->id();
        $uniqueFolder = 'applications/' . $userId . '/' . $id . '/' . Str::random(10);
        
        if ($request->hasFile('documents')) {
            $files = $request->file('documents');
            $zipFileName = 'documents_' . time() . '.zip';
            $zipFilePath = $uniqueFolder . '/' . $zipFileName;
            
            // Create a new zip archive
            $zip = new ZipArchive();
            
            // Create temporary file to store the zip
            $tempFile = tempnam(sys_get_temp_dir(), 'zip');
            
            if ($zip->open($tempFile, ZipArchive::CREATE) === TRUE) {
                foreach ($files as $file) {
                    $fileName = $file->getClientOriginalName();
                    // Add file to zip
                    $zip->addFile($file->getRealPath(), $fileName);
                }
                
                $zip->close();
                
                // Store the zip file
                Storage::put($zipFilePath, file_get_contents($tempFile));
                
                // Delete the temp file
                unlink($tempFile);
                
                // Create the application record
                policy_applications::create([
                    'User_ID' => $userId,
                    'Policy_ID' => $id,
                    'Status' => 'pending',
                    'Requirements_path' => $zipFilePath,
                    'notes' => $request->notes
                ]);
                
                return redirect()->route('my.applications')->with('success', 'Your policy application has been submitted successfully.');
            } else {
                return back()->with('error', 'Failed to create zip archive. Please try again.');
            }
        }
        return back()->with('error', 'No documents were uploaded. Please try again.');
    }
     /**
     * Display the user's applications.
     */
    public function myApplications()
    {
        $applications = policy_applications::with('policy')
            ->where('User_ID', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        $title = 'My Applications';
        $activePage = 'applications';
        $activeButton = 'laravel';
        $navName = 'My Applications';
        
        return view('customer.my_applications', compact('applications', 'title', 'activePage', 'activeButton', 'navName'));
    }

    /**
     * Display details of a specific application
     */
    public function viewApplication($id)
    {
        $application = policy_applications::where('Application_ID', $id)
            ->where('User_ID', auth()->id())
            ->with(['policy', 'documents'])
            ->firstOrFail();
        
        return view('customer.application_details', [
            'application' => $application,
            'title' => 'Application Details',
            'activePage' => 'My Applications',
            'activeButton' => 'laravel',
            'navName' => 'Application Details'
        ]);
    }
}
