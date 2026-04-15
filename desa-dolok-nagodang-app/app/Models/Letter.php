<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'letters';

    protected $fillable = [
        'letter_number',
        'letter_type_id',
        'citizen_id',
        'subject',
        'description',
        'status',
        'submission_date',
        'approved_date',
        'approved_by',
        'result_file',
        'notes',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'approved_date' => 'date',
    ];

    public function letterType()
    {
        return $this->belongsTo(LetterType::class, 'letter_type_id');
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'citizen_id');
    }
}