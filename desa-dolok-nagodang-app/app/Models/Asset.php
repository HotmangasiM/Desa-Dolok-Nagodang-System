<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assets';

    protected $fillable = [
        'item_name',
        'item_code',
        'category',
        'quantity',
        'condition',
        'location',
        'acquisition_date',
        'source',
        'asset_value',
        'asset_photo',
        'notes',
        'description',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'asset_value' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Label kondisi untuk ditampilkan di UI.
     */
    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'good' => 'Baik',
            'damaged' => 'Rusak',
            default => '-',
        };
    }
}