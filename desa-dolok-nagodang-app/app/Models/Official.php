<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Official extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'officials';

    protected $fillable = [
        'name',
        'position',
        'photo',
        'phone',
        'email',
        'address',
        'term_start',
        'term_end',
        'order',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'term_start' => 'date',
        'term_end' => 'date',
    ];

    public function scopeOrderedForDisplay($query)
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->orderBy('id');
    }
}
