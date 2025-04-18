<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $role = auth()->user()->role;

    return match($role) {
        'admin' => view('admin.admindashboard'),
        'customer' => view('customer.dashboard'),
        'underwriter' => view('underwriter.dashboard'),
        default => abort(403),
    };
}

}
