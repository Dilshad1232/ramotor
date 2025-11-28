<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($request->all());

        return back()->with([
            'success' => 'Message sent successfully!',
            'name' => $contact->name,
            'email' => $contact->email,
            'subject' => $contact->subject,
            'phone' => $contact->phone,
            'message_text' => $contact->message,
        ]);

    }
    
}
