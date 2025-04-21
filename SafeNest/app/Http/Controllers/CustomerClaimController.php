<?php

//namespace App\Http\Controllers\Customer;
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\Auth;



class CustomerClaimController extends Controller
{
    // Show form
    public function create()
    {
        $policies = Policy::all(); // Show available policies to claim against
        //return view('clients.claims.create', compact('policies'));

       // dd($policies);
       // dd($policies->first());
      // dd($policies->first()->getAttributes());

      



        return view('customer.claims.create', [
            'policies' => $policies,
            'activePage' => 'claims',
            'title' => 'Submit Claim',
            'navName' => 'Claims',
            'activeButton' => 'claims'
        ]);
    }

    // Submit form
    public function store(Request $request)
    {
       // dd('Store method hit!',$request->all());
       // dd($request->all());


        // Validate the request data
        $request->validate([
            'policy_id' => 'required|exists:policies,Policy_ID',
            'description' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,zip,rar,csv,webp,mp4,avi,mkv|max:40480'
, 
        ]);

        $path = null;

          if ($request->hasFile('attachment')) {
               $path = $request->file('attachment')->store('claims_attachments', 'public');
                 }
    
        // // Ensure the user is authenticated
        // if (!auth()->check()) {
        //     // If user is not authenticated, return an error or redirect
        //     return redirect()->route('login')->with('error', 'You must be logged in to submit a claim.');
        // }
    
        // Now that we're sure the user is authenticated, create the claim
        $claim = Claim::create([
            'user_id' => auth()->id(),  // Using the logged-in user ID
            'Policy_ID' => $request->policy_id,
            'Description' => $request->description, // Make sure the field is consistent with the DB column
            'Status' => 'pending', // Initial status is 'Pending'
            'attachment' => $path,

        ]);

       // dd($claim);

    
        // Optional: Log claim creation (if needed for debugging)
        // Log::info('Claim Created:', $claim->toArray());
    
        // // Redirect to the claims index page with a success message
         return redirect()->route('customer.claims.index')->with('success', 'Claim submitted successfully!');
    }
    

    // List user's submitted claims
    public function index()
    {
        $claims = Claim::where('user_id', auth()->id())->with('policy')->get(); // Replace 1 with auth()->id() when ready
        //$claims = Claim::where('user_id', auth()->id())->get();

        //return view('customer.claims.index', compact('claims'));

        return view('customer.claims.index', [
            'claims' => $claims,
            'activePage' => 'claims',
            'title' => 'Claims',
            'navName' => 'Claims',
            'activeButton' => 'claims'
        ]);
    }
    
}
