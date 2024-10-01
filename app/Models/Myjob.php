<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myjob extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'location',
        'description',
        'salary',
        'company_name',
        'company_description',
        'contact_email',
        'contact_phone',
    ];
}
