<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'document_type_id',
        'consignment_id',
        'document_number',
        'status',
        'creation_method',
        'form_data',
        'pdf_path',
        'pdf_generated_at',
        'credits_used',
        'version',
        'cloned_from',
        'notes',
    ];

    protected $casts = [
        'form_data' => 'array',
        'pdf_generated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function consignment(): BelongsTo
    {
        return $this->belongsTo(Consignment::class)->nullable();
    }

    public function clonedFrom(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'cloned_from')->nullable();
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
