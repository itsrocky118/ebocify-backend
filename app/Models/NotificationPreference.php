<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_document_created',
        'email_credit_low',
        'email_certificate_expiring',
        'email_monthly_summary',
        'email_product_updates',
        'push_document_ready',
        'push_audit_completed',
    ];

    protected $casts = [
        'email_document_created' => 'boolean',
        'email_credit_low' => 'boolean',
        'email_certificate_expiring' => 'boolean',
        'email_monthly_summary' => 'boolean',
        'email_product_updates' => 'boolean',
        'push_document_ready' => 'boolean',
        'push_audit_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
