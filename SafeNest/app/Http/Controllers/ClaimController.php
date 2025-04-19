<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Policy;
use App\Mail\ClaimStatusUpdated;
use Illuminate\Support\Facades\Mail;

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

    $claim->refresh();

     // Send email to the customer
     if ($claim->user && $claim->user->email) {
        Mail::to($claim->user->email)->send(new ClaimStatusUpdated($claim));
    }

    return redirect()->back()->with('success', 'Claim status updated.');
}
}
