<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $documentTypes = [
            // Institutional Documents
            [
                'category' => 'institutional',
                'name' => 'Certificate of Origin',
                'slug' => 'certificate-of-origin',
                'description' => 'Official document certifying the country of origin',
                'credit_cost_manual' => 2,
                'credit_cost_ai' => 3,
                'icon' => 'certificate',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category' => 'institutional',
                'name' => 'Bill of Lading',
                'slug' => 'bill-of-lading',
                'description' => 'Shipping document acknowledging receipt of goods',
                'credit_cost_manual' => 2,
                'credit_cost_ai' => 3,
                'icon' => 'file',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category' => 'institutional',
                'name' => 'Packing List',
                'slug' => 'packing-list',
                'description' => 'Detailed list of items and packaging information',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'list',
                'is_active' => true,
                'sort_order' => 3,
            ],
            // Commercial Documents
            [
                'category' => 'commercial',
                'name' => 'Commercial Invoice',
                'slug' => 'commercial-invoice',
                'description' => 'Standard invoice for international trade',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'invoice',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'category' => 'commercial',
                'name' => 'Proforma Invoice',
                'slug' => 'proforma-invoice',
                'description' => 'Preliminary invoice before goods shipment',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'invoice',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'category' => 'commercial',
                'name' => 'Delivery Note',
                'slug' => 'delivery-note',
                'description' => 'Document confirming goods delivery',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'truck',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'category' => 'commercial',
                'name' => 'Purchase Order',
                'slug' => 'purchase-order',
                'description' => 'Order document from buyer to seller',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'shopping-cart',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'category' => 'commercial',
                'name' => 'Sales Order',
                'slug' => 'sales-order',
                'description' => 'Order confirmation from seller to buyer',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'check-circle',
                'is_active' => true,
                'sort_order' => 8,
            ],
            // Financial Documents
            [
                'category' => 'financial',
                'name' => 'Letter of Credit',
                'slug' => 'letter-of-credit',
                'description' => 'Bank-issued payment guarantee',
                'credit_cost_manual' => 3,
                'credit_cost_ai' => 4,
                'icon' => 'bank',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'category' => 'financial',
                'name' => 'Bank Statement',
                'slug' => 'bank-statement',
                'description' => 'Official bank account statement',
                'credit_cost_manual' => 2,
                'credit_cost_ai' => 3,
                'icon' => 'file-text',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'category' => 'financial',
                'name' => 'Payment Receipt',
                'slug' => 'payment-receipt',
                'description' => 'Confirmation of payment received',
                'credit_cost_manual' => 1,
                'credit_cost_ai' => 2,
                'icon' => 'receipt',
                'is_active' => true,
                'sort_order' => 11,
            ],
        ];

        foreach ($documentTypes as $type) {
            DocumentType::create($type);
        }
    }
}
