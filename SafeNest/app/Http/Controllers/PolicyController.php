<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\ApprovedPolicy;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $policies = Policy::all();
        $title = 'Policies'; 
        $activePage='policies';
        $activeButton = 'laravel';
        $navName = 'Policies';
        
        return view('underwriter.policies.index', compact('policies', 'title', 'activePage','activeButton','navName'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Policy';
        $activePage = 'policies';
        $activeButton = 'laravel';
        $navName = 'Policies';
        return view('underwriter.policies.create', compact('title','activePage','activeButton','navName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:50',
            'Description' => 'required|string|max:50',
            'Premium' => 'required|string|max:50',
            'Duration' => 'required|integer',
        ]);

        Policy::create($request->all());

        return redirect()->route('policies.index')->with('success', 'Policy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $policy = Policy::findOrFail($id);
        $approvedPolicy = ApprovedPolicy::where('Policy_ID', $id)
            ->where('User_ID', auth()->id())
            ->first();
        
        if (request()->ajax()) {
            // Return JSON for modal
            return response()->json([
                'policy' => $policy,
                'approvedPolicy' => $approvedPolicy
            ]);
        }
        
        $title = 'Policy Details';
        $activePage = 'policies';
        $activeButton = 'laravel';
        $navName = 'Policies';
        
        return view('customer.policy_details', compact('policy', 'approvedPolicy', 'title', 'activePage', 'activeButton', 'navName'));
    }
        /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $policy = Policy::findOrFail($id);
        $title = 'Policies'; 
        $activePage = 'policies';
        $activeButton = 'laravel';
        $navName = 'Policies';
        return view('underwriter.policies.edit', compact('policy', 'title','activePage','activeButton','navName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $policy = Policy::findOrFail($id);

        $request->validate([
            'Title' => 'required|string|max:50',
            'Description' => 'required|string|max:50',
            'Premium' => 'required|string|max:50',
            'Duration' => 'required|integer|min:1',
        ]);

        $policy->update($request->all());

        return redirect()->route('policies.index')->with('success', 'Policy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Policy::destroy($id);
        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully.');
    }

    //for the home display of policies
        public function customerPolicies()
        {
        $policies = Policy::all();
        $title = 'Available Policies';
        $activePage = 'customer_policies';
        $activeButton = 'laravel';
        $navName = 'Policies';
        return view('customer.homepolicies', compact('policies', 'title', 'activePage','activeButton','navName'));
        }

}
