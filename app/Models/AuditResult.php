<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'consignment_id',
        'status',
        'total_checks',
        'passed_checks',
        'warning_checks',
        'failed_checks',
        'score_percentage',
        'credits_used',
        'started_at',
        'completed_at',
        'report_pdf_path',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'score_percentage' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function consignment(): BelongsTo
    {
        return $this->belongsTo(Consignment::class);
    }

    public function checkItems(): HasMany
    {
        return $this->hasMany(AuditCheckItem::class, 'audit_id');
    }
}
