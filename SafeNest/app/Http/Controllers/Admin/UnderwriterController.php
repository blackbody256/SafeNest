<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Underwriter;
use App\Models\User;

class UnderwriterController extends Controller
{
    public function index()
    {
        $underwriters = Underwriter::with('user')->latest()->paginate(10);
        
        return view('admin.underwriters.index', compact('underwriters'));
    }

    public function create()
    {
        $users = User::where('role', '!=', 'underwriter')
                   ->where('role', '!=', 'admin')
                   ->doesntHave('underwriter')
                   ->get();
                   
        return view('admin.underwriters.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:underwriters'
        ]);

        // Update user role
        $user = User::find($request->user_id);
        $user->update(['role' => 'underwriter']);

        // Create underwriter profile with default 5% commission
        Underwriter::create(['user_id' => $user->id]);

        return redirect()->route('admin.underwriters.index')
               ->with('success', 'Underwriter created with 5% commission!');
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
        // Revert user role to customer
        $underwriter->user->update(['role' => 'customer']);
        
        $underwriter->delete();

        return back()->with('success', 'Underwriter removed!');
    }
}