<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\policy_applications;

class PoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPolicies = Policy::count();
        $totalApplications = policy_applications::count();
        $approvedPolicies = policy_applications::where('status', 'approved')->count();
        $pendingPolicies = policy_applications::where('status', 'pending')->count();
        $rejectedPolicies = policy_applications::where('status', 'rejected')->count();
        $recentPolicies = Policy::latest('created_at')->take(10)->get();
        
        $recentApplications = policy_applications::with(['user', 'policy'])
                        ->latest('created_at')
                        ->take(10)
                        ->get();

        return view('admin.policies.index', [
            'totalPolicies' => $totalPolicies,
            'totalApplications' => $totalApplications,
            'approvedPolicies' => $approvedPolicies,
            'pendingPolicies' => $pendingPolicies,
            'rejectedPolicies' => $rejectedPolicies,
            'recentPolicies' => $recentPolicies,
            'recentApplications' => $recentApplications
        ]
    
    );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
