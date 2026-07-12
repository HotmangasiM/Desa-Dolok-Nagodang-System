<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'letters';

    protected $fillable = [
        'letter_number',
        'letter_type_id',
        'applicant_national_id',
        'subject',
        'description',
        'payload',
        'submission_date',
        'verification_date',
        'approval_date',
        'status',
        'notes',
        'result_file',
        'created_by',
        'approved_by',
    ];
    
    protected $casts = [
        'payload' => 'array',
        'submission_date' => 'datetime',
        'verification_date' => 'datetime',
        'approval_date' => 'datetime',
    ];

    public function letterType()
    {
        return $this->belongsTo(LetterType::class, 'letter_type_id');
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'applicant_national_id', 'nik');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}