<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\UserDeletedNotification;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // You need to pass the variables used in your view
        $totalUsers = User::count();
        $underwritersCount = User::where('role', 'underwriter')->count();
        $customersCount = User::where('role', 'customer')->count();
        $adminsCount = User::where('role', 'admin')->count();
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', [
            'totalUsers' => $totalUsers,
            'underwritersCount' => $underwritersCount,
            'customersCount' => $customersCount,
            'adminsCount' => $adminsCount,
            'users' => $users
    ]);
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
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $userEmail = $user->email;
    $userName = $user->name;

    // Send email before deletion
    Mail::to($userEmail)->send(new UserDeletedNotification($userName));

    // Delete user
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User deleted and notified.');
}

}
