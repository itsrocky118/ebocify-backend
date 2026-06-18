<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'default_currency',
        'timezone',
        'date_format',
        'language',
        'theme',
        'compact_mode',
        'items_per_page',
        'default_document_type_id',
        'auto_save_drafts',
        'auto_assign_consignment_id',
        'show_credit_cost',
    ];

    protected $casts = [
        'compact_mode' => 'boolean',
        'auto_save_drafts' => 'boolean',
        'auto_assign_consignment_id' => 'boolean',
        'show_credit_cost' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function defaultDocumentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'default_document_type_id')->nullable();
    }
}
