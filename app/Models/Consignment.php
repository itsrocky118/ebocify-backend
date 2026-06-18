<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'consignment_number',
        'exporter_name',
        'exporter_address',
        'exporter_country',
        'importer_name',
        'importer_address',
        'importer_country',
        'port_of_loading',
        'port_of_discharge',
        'shipment_date',
        'vessel_flight_number',
        'container_numbers',
        'incoterms',
        'payment_terms',
        'total_value',
        'currency',
        'status',
        'notes',
    ];

    protected $casts = [
        'container_numbers' => 'array',
        'shipment_date' => 'date',
        'total_value' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(ConsignmentProduct::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function auditResults(): HasMany
    {
        return $this->hasMany(AuditResult::class);
    }
}
