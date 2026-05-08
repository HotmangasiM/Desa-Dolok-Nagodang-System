<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'category',
        'message',
        'attachment',
        'status',
        'ip_address',
    ];
}
