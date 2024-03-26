<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'lead_source' => 'nullable|string',
            'past_client' => 'nullable|boolean',
            'phone' => 'nullable|string',
            'organization' => 'nullable|string',
        ]);

        $contact = Contact::create($validatedData);

        return response()->json($contact, 201);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'lead_source' => 'nullable|string',
            'past_client' => 'nullable|boolean',
            'phone' => 'nullable|string',
            'organization' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validatedData);

        return response()->json($contact, 200);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
