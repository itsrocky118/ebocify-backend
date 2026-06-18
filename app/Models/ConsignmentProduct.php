<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsignmentProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'description',
        'hs_code',
        'quantity',
        'unit',
        'unit_price',
        'total_price',
        'net_weight',
        'gross_weight',
        'dimensions',
        'packages_count',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'net_weight' => 'decimal:2',
        'gross_weight' => 'decimal:2',
    ];

    public function consignment(): BelongsTo
    {
        return $this->belongsTo(Consignment::class);
    }
}
