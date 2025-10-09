<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'fileable_id',
        'fileable_type',
        'path',
        'original_name',
        'mime_type',
        'size',
    ];

    protected $appends = ['url', 'preview_url'];

    /**
     * Mendefinisikan relasi polymorphic 'fileable'.
     * Ini memungkinkan model File dimiliki oleh model lain (SuratMasuk, User, dll).
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * Accessor untuk URL download file.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => route('files.download', $this),
        );
    }
    
    /**
     * Accessor untuk URL preview file.
     */
    protected function previewUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('files.preview', $this),
        );
    }
}