<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use App\Services\AuditService;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    private AuditService $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Run audit on a consignment
     */
    public function run(Request $request)
    {
        $validated = $request->validate([
            'consignment_id' => 'required|exists:consignments,id',
        ]);

        $consignment = Consignment::findOrFail($validated['consignment_id']);

        if ($consignment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $audit = $this->auditService->runAudit($request->user(), $consignment);

        return response()->json([
            'message' => 'Audit completed successfully',
            'audit' => $audit->load('checkItems'),
        ], 201);
    }

    /**
     * Get audit result
     */
    public function show(Request $request, $auditId)
    {
        $audit = $request->user()->auditResults()->findOrFail($auditId);

        return response()->json($audit->load('checkItems', 'consignment'));
    }

    /**
     * Get all audits for user
     */
    public function index(Request $request)
    {
        $audits = $request->user()->auditResults()
            ->with('consignment')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($audits);
    }
}
