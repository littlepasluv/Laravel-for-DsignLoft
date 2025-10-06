<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'firebase_uid',
        'user_data',
        'profile_photo_url'
    ];

    protected $casts = [
        'user_data' => 'array'
    ];
}
