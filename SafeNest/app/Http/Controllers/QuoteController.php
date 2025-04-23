<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Policy;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;


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

    // Filter expired quotes where duration is in the past
    $expiredQuotes = Quote::with(['user', 'policy'])
        ->whereHas('policy', function ($query) {
            $query->where('Duration', '<', now());
        })->get();

    return view('underwriter.quotes.index', [
        'quotes' => $quotes,
        'expiredQuotes' => $expiredQuotes,
        'title' => 'Manage Quotes',
        'activePage' => 'quotes',
        'activeButton' => 'quotes',
        'navName' => 'Quotes'
    ]);
}

public function destroy($id)
{
    $quote = Quote::findOrFail($id);
    $quote->delete();
    return redirect()->back()->with('success', 'Quote deleted successfully.');
}

public function destroyExpired()
{
    $expiredQuotes = Quote::whereHas('policy', function ($query) {
        $query->where('Duration', '<', now());
    });

    $count = $expiredQuotes->count();
    $expiredQuotes->delete();

    return redirect()->back()->with('success', "$count expired quotes deleted successfully.");
}


    public function testCalculation()
{
    // Simulate a request
    $request = new \Illuminate\Http\Request();
    $request->merge(['policy_id' => 1]); // You can change this ID

    // Run the quote logic
    return $this->requestQuote($request, 1); // Assuming 1 is the policy ID
}

public function store(Request $request)
    {
            $policy = Policy::findOrFail($request->policy_id);
            $endDate = Carbon::parse($policy->Duration);
            $startDate = Carbon::now();

            // Calculate total number of months for the policy
            $totalMonths = max($startDate->diffInMonths($endDate), 1); // fallback to at least 1

            // Final quote calculation
            $quoteAmount = $policy->Premium * $totalMonths;


        // Save quote to DB
        $quote = new Quote();
        $quote->user_id = $request->user_id;
        $quote->Policy_ID = $policy->Policy_ID;
        $quote->Description = $policy->Description;
        $quote->Amount = $quoteAmount;
        $quote->save();

        return redirect()->route('policy.catalogue')->with([
            'success' => 'Quote requested successfully!',
            'quote_amount' => $quoteAmount,
            'quote_policy_id' => $policy->Policy_ID,
        ]);
        
    }

}
