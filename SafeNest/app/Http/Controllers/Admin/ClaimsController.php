<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimsController extends Controller
{
    public function index()
    {
        $claimsByStatus = Claim::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $totalClaims = array_sum($claimsByStatus);
        $claimsByStatus = array_change_key_case($claimsByStatus, CASE_LOWER);
        $approvedClaims = $claimsByStatus['Approved'] ?? 0;
        $pendingClaims = $claimsByStatus['Pending'] ?? 0;
        $rejectedClaims = $claimsByStatus['Rejected'] ?? 0;

        $recentClaims = Claim::with(['policy', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.claims.index', [
            'totalClaims' => $totalClaims,
            'approvedClaims' => $approvedClaims,
            'pendingClaims' => $pendingClaims,
            'rejectedClaims' => $rejectedClaims,
            'claimsByStatus' => $claimsByStatus,
            'recentClaims' => $recentClaims
        ]);
    }
}