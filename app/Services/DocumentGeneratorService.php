<?php

namespace App\Services;

use App\Models\User;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Str;

class DocumentGeneratorService
{
    private CreditService $creditService;

    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
    }

    /**
     * Generate unique document number
     */
    public function generateDocumentNumber(DocumentType $type): string
    {
        $prefix = strtoupper(substr($type->slug, 0, 3));
        $year = now()->year;
        $count = Document::where('document_type_id', $type->id)
            ->whereYear('created_at', $year)
            ->count() + 1;

        return "{$prefix}-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new document
     */
    public function createDocument(User $user, DocumentType $type, array $formData, string $method = 'manual'): ?Document
    {
        $creditCost = $method === 'ai' ? $type->credit_cost_ai : $type->credit_cost_manual;

        // Check credits
        if (!$this->creditService->hasEnoughCredits($user, $creditCost)) {
            return null;
        }

        // Deduct credits
        $this->creditService->deductCredits(
            $user,
            $creditCost,
            "Document creation: {$type->name}",
            'document',
            null
        );

        // Create document
        $document = Document::create([
            'user_id' => $user->id,
            'document_type_id' => $type->id,
            'document_number' => $this->generateDocumentNumber($type),
            'status' => 'draft',
            'creation_method' => $method,
            'form_data' => $formData,
            'credits_used' => $creditCost,
        ]);

        return $document;
    }

    /**
     * Clone a document
     */
    public function cloneDocument(Document $document): Document
    {
        $cloned = $document->replicate();
        $cloned->document_number = $this->generateDocumentNumber($document->documentType);
        $cloned->status = 'draft';
        $cloned->cloned_from = $document->id;
        $cloned->version = 1;
        $cloned->save();

        return $cloned;
    }

    /**
     * Update document
     */
    public function updateDocument(Document $document, array $formData): Document
    {
        $document->update([
            'form_data' => $formData,
            'version' => $document->version + 1,
        ]);

        return $document;
    }

    /**
     * Complete document (mark as completed)
     */
    public function completeDocument(Document $document): Document
    {
        $document->update(['status' => 'completed']);
        return $document;
    }
}
