<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    /**
     * Get all consignments for authenticated user
     */
    public function index(Request $request)
    {
        $consignments = $request->user()->consignments()
            ->with('products', 'documents')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($consignments);
    }

    /**
     * Create a new consignment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'consignment_number' => 'required|unique:consignments,consignment_number',
            'exporter_name' => 'required|string|max:200',
            'exporter_address' => 'required|string',
            'exporter_country' => 'required|string|max:100',
            'importer_name' => 'required|string|max:200',
            'importer_address' => 'required|string',
            'importer_country' => 'required|string|max:100',
            'port_of_loading' => 'required|string|max:200',
            'port_of_discharge' => 'required|string|max:200',
            'shipment_date' => 'nullable|date',
            'total_value' => 'required|numeric|min:0',
            'currency' => 'required|string|max:5',
        ]);

        $consignment = $request->user()->consignments()->create($validated);

        return response()->json([
            'message' => 'Consignment created successfully',
            'consignment' => $consignment,
        ], 201);
    }

    /**
     * Get a single consignment
     */
    public function show(Request $request, Consignment $consignment)
    {
        if ($consignment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($consignment->load('products', 'documents'));
    }

    /**
     * Update consignment
     */
    public function update(Request $request, Consignment $consignment)
    {
        if ($consignment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'exporter_name' => 'string|max:200',
            'exporter_address' => 'string',
            'exporter_country' => 'string|max:100',
            'importer_name' => 'string|max:200',
            'importer_address' => 'string',
            'importer_country' => 'string|max:100',
            'port_of_loading' => 'string|max:200',
            'port_of_discharge' => 'string|max:200',
            'shipment_date' => 'nullable|date',
            'total_value' => 'numeric|min:0',
        ]);

        $consignment->update($validated);

        return response()->json([
            'message' => 'Consignment updated successfully',
            'consignment' => $consignment,
        ]);
    }

    /**
     * Delete consignment
     */
    public function destroy(Request $request, Consignment $consignment)
    {
        if ($consignment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $consignment->delete();

        return response()->json(['message' => 'Consignment deleted successfully']);
    }
}
