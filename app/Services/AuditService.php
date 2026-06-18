<?php

namespace App\Services;

use App\Models\Consignment;
use App\Models\Document;
use App\Models\AuditResult;
use App\Models\AuditCheckItem;
use App\Models\User;

class AuditService
{
    /**
     * Run audit on a consignment
     */
    public function runAudit(User $user, Consignment $consignment): AuditResult
    {
        $audit = AuditResult::create([
            'user_id' => $user->id,
            'consignment_id' => $consignment->id,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        // Run various checks
        $this->runIdentityChecks($audit, $consignment);
        $this->runProductChecks($audit, $consignment);
        $this->runShippingChecks($audit, $consignment);
        $this->runDocumentConsistencyChecks($audit, $consignment);

        // Calculate results
        $this->calculateAuditScore($audit);

        return $audit;
    }

    /**
     * Run identity checks
     */
    private function runIdentityChecks(AuditResult $audit, Consignment $consignment): void
    {
        // Check exporter name consistency
        $documents = $consignment->documents()->get();
        $exporterNames = $documents->pluck('form_data->exporter_name')->unique();

        if ($exporterNames->count() > 1) {
            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'identity',
                'check_name' => 'Exporter Name Consistency',
                'check_description' => 'Exporter names should be consistent across all documents',
                'status' => 'failed',
                'details' => ['found' => $exporterNames->toArray()],
            ]);
        } else {
            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'identity',
                'check_name' => 'Exporter Name Consistency',
                'check_description' => 'Exporter names should be consistent across all documents',
                'status' => 'passed',
            ]);
        }
    }

    /**
     * Run product checks
     */
    private function runProductChecks(AuditResult $audit, Consignment $consignment): void
    {
        $products = $consignment->products()->get();

        if ($products->isEmpty()) {
            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'product',
                'check_name' => 'Product Information',
                'check_description' => 'At least one product should be listed',
                'status' => 'failed',
            ]);
        } else {
            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'product',
                'check_name' => 'Product Information',
                'check_description' => 'Product information is complete',
                'status' => 'passed',
            ]);
        }
    }

    /**
     * Run shipping checks
     */
    private function runShippingChecks(AuditResult $audit, Consignment $consignment): void
    {
        $issues = [];

        if (empty($consignment->port_of_loading)) {
            $issues[] = 'Port of loading is missing';
        }

        if (empty($consignment->port_of_discharge)) {
            $issues[] = 'Port of discharge is missing';
        }

        if (empty($consignment->shipment_date)) {
            $issues[] = 'Shipment date is missing';
        }

        if (count($issues) > 0) {
            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'shipping',
                'check_name' => 'Shipping Information',
                'check_description' => 'All shipping details should be provided',
                'status' => 'failed',
                'details' => ['issues' => $issues],
            ]);
        } else {
            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'shipping',
                'check_name' => 'Shipping Information',
                'check_description' => 'All shipping information is complete',
                'status' => 'passed',
            ]);
        }
    }

    /**
     * Run document consistency checks
     */
    private function runDocumentConsistencyChecks(AuditResult $audit, Consignment $consignment): void
    {
        $documents = $consignment->documents()->get();

        if ($documents->count() >= 2) {
            $firstDoc = $documents->first();
            $allConsistent = true;

            foreach ($documents->slice(1) as $doc) {
                if ($firstDoc->form_data['total_value'] != $doc->form_data['total_value'] ?? false) {
                    $allConsistent = false;
                    break;
                }
            }

            AuditCheckItem::create([
                'audit_id' => $audit->id,
                'check_category' => 'consistency',
                'check_name' => 'Document Value Consistency',
                'check_description' => 'All documents should have consistent total values',
                'status' => $allConsistent ? 'passed' : 'warning',
            ]);
        }
    }

    /**
     * Calculate audit score
     */
    private function calculateAuditScore(AuditResult $audit): void
    {
        $checkItems = $audit->checkItems()->get();

        $total = $checkItems->count();
        $passed = $checkItems->where('status', 'passed')->count();
        $warnings = $checkItems->where('status', 'warning')->count();
        $failed = $checkItems->where('status', 'failed')->count();

        $score = $total > 0 ? ($passed / $total) * 100 : 0;

        $audit->update([
            'total_checks' => $total,
            'passed_checks' => $passed,
            'warning_checks' => $warnings,
            'failed_checks' => $failed,
            'score_percentage' => $score,
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
