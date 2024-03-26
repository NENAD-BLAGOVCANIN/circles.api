<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class LeadsController extends Controller
{
    public function index()
    {
        // Retrieve all leads
        $leads = Lead::all();
        return response()->json($leads);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'description' => 'nullable|string',
            'lead_source' => 'nullable|string',
        ]);

        // Create a new lead
        $lead = Lead::create($validatedData);

        return response()->json($lead, 201);
    }

    public function show($id)
    {
        // Find a lead by ID
        $lead = Lead::findOrFail($id);
        return response()->json($lead);
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'description' => 'nullable|string',
            'lead_source' => 'nullable|string',
        ]);

        // Find the lead by ID and update
        $lead = Lead::findOrFail($id);
        $lead->update($validatedData);

        return response()->json($lead, 200);
    }

    public function destroy($id)
    {
        // Find the lead by ID and delete
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json(null, 204);
    }
}
