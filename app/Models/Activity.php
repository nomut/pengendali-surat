<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'date',
        'is_published',
        'views',
    ];

    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
        'views' => 'integer',
    ];
}
