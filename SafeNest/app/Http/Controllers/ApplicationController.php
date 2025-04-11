<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with('user', 'policy')->get();

        return view('underwriter.applications.index', compact('applications'));
    }

    public function approve($id)
    {
        $application = Application::findOrFail($id);
        $application->Status = 'Approved';
        $application->save();

        return redirect()->route('applications.index')->with('success', 'Policy approved successfully.');
    }

    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->Status = 'Rejected';
        $application->save();

        return redirect()->route('applications.index')->with('success', 'Policy rejected successfully.');
    }
}
