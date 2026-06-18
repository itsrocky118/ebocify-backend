<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'documents_per_month',
        'has_ai_assistant',
        'has_audit_tool',
        'has_compliance_tracker',
        'has_digital_vault',
        'has_all_doc_types',
        'has_priority_support',
        'has_dedicated_manager',
        'has_team_accounts',
        'has_api_access',
        'has_sla_guarantee',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'has_ai_assistant' => 'boolean',
        'has_audit_tool' => 'boolean',
        'has_compliance_tracker' => 'boolean',
        'has_digital_vault' => 'boolean',
        'has_all_doc_types' => 'boolean',
        'has_priority_support' => 'boolean',
        'has_dedicated_manager' => 'boolean',
        'has_team_accounts' => 'boolean',
        'has_api_access' => 'boolean',
        'has_sla_guarantee' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
