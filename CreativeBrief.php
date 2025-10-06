<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreativeBrief extends Model
{
    use HasFactory;

    protected $fillable = [
        'firebase_uid',
        'brief_data'
    ];

    protected $casts = [
        'brief_data' => 'array'
    ];
}
