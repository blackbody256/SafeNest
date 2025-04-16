<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Policy;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class QuoteController extends Controller
{
    // Client requests a quote
    public function requestQuote($userId, $policyId)
    {
        //$userId = Auth::id();
        $user = User::findOrFail($userId);
        $policy = Policy::findOrFail($policyId);

    // Fetch existing quote to prevent duplicates
          $existingQuote = Quote::where('user_id', $userId)
                                  ->where('policy_id', $policyId)
                                  ->first();

                        if ($existingQuote) {
                                    return redirect()->back()->with('error', 'A quote already exists for this user and policy.');
                                }
    




                                                      

        // ✨ Calculate amount based on custom logic
        $baseAmount = $policy->Premium;
        $durationFactor = $policy->Duration ?? 1;
        $quoteAmount = $baseAmount + ($durationFactor * 50);

        $quote = Quote::create([
            'user_id' => $userId,
            'Policy_ID' => $policy->Policy_ID,
            'Description' => 'Initial calculated quote for ' . $policy->Title,
            'Amount' => $quoteAmount,
        ]);

        return redirect()->back()->with('success', 'Quote requested successfully!');
    }

    // Underwriter sees all quotes
    public function index()
    {
        $quotes = Quote::with(['user', 'policy'])->get();
        return view('underwriter.quotes.index', [
            'quotes' => $quotes,
            'title' => 'Manage Quotes',
            'activePage' => 'quotes',
            'activeButton' => 'quotes',
            'navName' => 'Quotes'
        ]);
    }

    public function testCalculation()
{
    // Simulate a request
    $request = new \Illuminate\Http\Request();
    $request->merge(['policy_id' => 1]); // You can change this ID

    // Run the quote logic
    return $this->requestQuote($request, 1); // Assuming 1 is the policy ID
}

}
