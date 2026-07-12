<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterType extends Model
{
    use HasFactory;

    protected $table = 'letter_types';

    protected $fillable = [
        'name',
        'code',
        'description',
        'template_file',
        'is_active',
    ];

    public function letters()
    {
        return $this->hasMany(Letter::class, 'letter_type_id');
    }
}
