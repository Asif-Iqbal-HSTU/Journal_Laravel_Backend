<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paperfile extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }
}
