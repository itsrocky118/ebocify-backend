<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Services\DocumentGeneratorService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    private DocumentGeneratorService $documentService;

    public function __construct(DocumentGeneratorService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Get all documents for authenticated user
     */
    public function index(Request $request)
    {
        $documents = $request->user()->documents()
            ->with('documentType')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($documents);
    }

    /**
     * Create a new document
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'form_data' => 'required|array',
            'creation_method' => 'required|in:manual,ai',
            'consignment_id' => 'nullable|exists:consignments,id',
        ]);

        $documentType = DocumentType::findOrFail($validated['document_type_id']);

        $document = $this->documentService->createDocument(
            $request->user(),
            $documentType,
            $validated['form_data'],
            $validated['creation_method']
        );

        if (!$document) {
            return response()->json(['message' => 'Insufficient credits'], 402);
        }

        if ($validated['consignment_id'] ?? false) {
            $document->update(['consignment_id' => $validated['consignment_id']]);
        }

        return response()->json([
            'message' => 'Document created successfully',
            'document' => $document,
        ], 201);
    }

    /**
     * Get a single document
     */
    public function show(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($document->load('documentType'));
    }

    /**
     * Update document
     */
    public function update(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'form_data' => 'required|array',
        ]);

        $updated = $this->documentService->updateDocument($document, $validated['form_data']);

        return response()->json([
            'message' => 'Document updated successfully',
            'document' => $updated,
        ]);
    }

    /**
     * Clone document
     */
    public function clone(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cloned = $this->documentService->cloneDocument($document);

        return response()->json([
            'message' => 'Document cloned successfully',
            'document' => $cloned,
        ], 201);
    }

    /**
     * Delete document
     */
    public function destroy(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
