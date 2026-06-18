<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditCheckItem extends Model
{
    use HasFactory;

    protected $table = 'audit_check_items';

    protected $fillable = [
        'audit_id',
        'check_category',
        'check_name',
        'check_description',
        'status',
        'details',
        'document_ids_involved',
    ];

    protected $casts = [
        'details' => 'array',
        'document_ids_involved' => 'array',
    ];

    public function audit(): BelongsTo
    {
        return $this->belongsTo(AuditResult::class, 'audit_id');
    }
}
