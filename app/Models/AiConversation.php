<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type_id',
        'status',
        'messages',
        'extracted_data',
        'created_document_id',
        'credits_used',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'messages' => 'array',
        'extracted_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class)->nullable();
    }

    public function createdDocument(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'created_document_id')->nullable();
    }
}
