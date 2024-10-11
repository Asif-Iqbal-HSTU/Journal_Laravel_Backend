<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    public function coAuthors()
    {
        return $this->hasMany(CoAuthor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status(): HasOne
    {
        return $this->hasOne(Paperstatus::class);
    }


}
