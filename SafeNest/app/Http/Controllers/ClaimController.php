<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Policy;

class ClaimController extends Controller
{
    public function index()
{
    $claims = Claim::with(['user', 'policy'])->get();
    //return view('underwriter.claims.index', compact('claims'));

    return view('underwriter.claims.index', [
        'claims' => $claims,
        'title' => 'Manage Claims',
        'activePage' => 'claims',
        'activeButton' => 'claims',
        'navName' => 'Manage Claims',
    ]);
}

public function updateStatus(Request $request, $id)
{
    $claim = Claim::findOrFail($id);
    $claim->status = $request->status;
    $claim->save();

    return redirect()->back()->with('success', 'Claim status updated.');
}
}
