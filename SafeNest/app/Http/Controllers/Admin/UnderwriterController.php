<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Underwriter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UnderwriterWelcomeMail;
use App\Models\Payments;

class UnderwriterController extends Controller
{
    public function index()
{
    $totalRevenue = Payments::sum('amount');
    $underwriterCommission = $totalRevenue * 0.05;

    // Fetch all underwriters
    $underwriters = Underwriter::with('user')->latest()->paginate(10);

    // Total weight = sum of all commission rates
    $totalCommissionRate = Underwriter::sum('commission_rate');

    // Calculate and store individual commissions
    $calculatedCommissions = [];

    foreach ($underwriters as $underwriter) {
        $share = ($underwriter->commission_rate / $totalCommissionRate);
        $commissionAmount = $share * $underwriterCommission;

        $calculatedCommissions[$underwriter->id] = round($commissionAmount, 2);
    }

    return view('admin.underwriters.index', compact('underwriters', 'calculatedCommissions'));
}


    public function create()
    {
        return view('admin.underwriters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'commission_rate' => 'nullable|numeric|between:0,100',
        ]);

        // Create user with 'underwriter' role
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'underwriter',
        ]);

        // Create underwriter profile
        $underwriter = Underwriter::create([
            'user_id' => $user->id,
            'commission_rate' => $validated['commission_rate'] ?? 5.00,
        ]);

        // Send welcome email with the original password
        Mail::to($user->email)->send(new UnderwriterWelcomeMail($user->name, $validated['password']));

        return redirect()->route('admin.underwriters.edit', $underwriter->id)
            ->with('success', 'Underwriter created and welcome email sent!');
    }

    public function edit(Underwriter $underwriter)
    {
        return view('admin.underwriters.edit', compact('underwriter'));
    }

    public function update(Request $request, Underwriter $underwriter)
    {
        $validated = $request->validate([
            'commission_rate' => 'required|numeric|between:0,100'
        ]);

        $underwriter->update($validated);

        return redirect()->route('admin.underwriters.index')
            ->with('success', 'Commission rate updated!');
    }

    public function destroy(Underwriter $underwriter)
{
    // Demote user to customer
    $underwriter->user->update(['role' => 'customer']);

    // Delete the underwriter profile
    $underwriter->delete();

    return redirect()->route('admin.underwriters.index')
        ->with('success', 'Underwriter has been demoted to customer and deleted.');
}

}
