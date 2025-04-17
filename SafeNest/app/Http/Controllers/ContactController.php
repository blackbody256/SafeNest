<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;


class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        //my email, with what has to be sent.
        Mail::to('selinamasembe27@gmail.com')->send(new ContactMessage($validated));

        return back()->with('success', 'Message sent successfully!');
    }
}
