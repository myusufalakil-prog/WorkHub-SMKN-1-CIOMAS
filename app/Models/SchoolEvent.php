<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    protected $fillable = [
        'title',
        'date_text',
        'status',
        'desc',
        'lead',
        'participants_info',
        'category',
    ];
}
