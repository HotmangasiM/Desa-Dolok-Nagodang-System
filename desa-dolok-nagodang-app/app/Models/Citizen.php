<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $fillable = [
        'nik',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'education',
        'occupation',
        'marital_status',
        'family_card_number',
        'family_role',
        'address',
        'rt',
        'rw',
        'village',
        'district',
        'regency',
        'province',
        'postal_code',
        'phone',
        'email',
        'life_status',
        'photo'
];
}
