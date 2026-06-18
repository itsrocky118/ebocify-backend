<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for beginners',
                'price_monthly' => 29.99,
                'price_yearly' => 299.99,
                'documents_per_month' => 50,
                'has_ai_assistant' => false,
                'has_audit_tool' => false,
                'has_compliance_tracker' => false,
                'has_digital_vault' => true,
                'has_all_doc_types' => false,
                'has_priority_support' => false,
                'has_dedicated_manager' => false,
                'has_team_accounts' => false,
                'has_api_access' => false,
                'has_sla_guarantee' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For growing businesses',
                'price_monthly' => 79.99,
                'price_yearly' => 799.99,
                'documents_per_month' => 500,
                'has_ai_assistant' => true,
                'has_audit_tool' => true,
                'has_compliance_tracker' => true,
                'has_digital_vault' => true,
                'has_all_doc_types' => true,
                'has_priority_support' => true,
                'has_dedicated_manager' => false,
                'has_team_accounts' => false,
                'has_api_access' => false,
                'has_sla_guarantee' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large organizations',
                'price_monthly' => 299.99,
                'price_yearly' => 2999.99,
                'documents_per_month' => null,
                'has_ai_assistant' => true,
                'has_audit_tool' => true,
                'has_compliance_tracker' => true,
                'has_digital_vault' => true,
                'has_all_doc_types' => true,
                'has_priority_support' => true,
                'has_dedicated_manager' => true,
                'has_team_accounts' => true,
                'has_api_access' => true,
                'has_sla_guarantee' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
