<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'images',
        'is_published',
    ];

    protected $casts = [
        'date' => 'date',
        'images' => 'json',
        'is_published' => 'boolean',
    ];
}
