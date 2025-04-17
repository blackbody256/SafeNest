<?php
namespace App\Http\Controllers;
use App\Models\Quote;
use App\Models\Claim;
use App\Models\ApprovedPolicy;
use Illuminate\Http\Request;


class underwriterDashboardController extends Controller
{
public function index(Request $request)
{
    $filter = $request->query('filter');

    // Filter approved policies
    $approvedPoliciesQuery = ApprovedPolicy::query();
    if ($filter === 'active') {
        $approvedPoliciesQuery->where('expires_at', '>', now());
    } elseif ($filter === 'expired') {
        $approvedPoliciesQuery->where('expires_at', '<', now());
    }
    $approvedPolicies = $approvedPoliciesQuery->get();

    
    return view('underwriter.dashboard', [
        'title' => 'Underwriter Dashboard',
        'activePage' => 'dashboard',
        'activeButton' => 'laravel',
        'navName' => 'Dashboard',
        'totalQuotes' => Quote::count(),
        'approvedCount' => $approvedPolicies->count(),
        'pendingClaims' => Claim::where('status', 'pending')->count(),
        'approvedPolicies' => $approvedPolicies,
    ]);
}
}