<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BriefItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'brief_id',
        'type',
        'value',
    ];

    public function brief(): BelongsTo
    {
        return $this->belongsTo(Brief::class);
    }
}
