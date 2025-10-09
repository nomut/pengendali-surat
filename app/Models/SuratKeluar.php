<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Tags\HasTags;

class SuratKeluar extends Model
{
    use HasTags;

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'tembusan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'datetime',
        ];
    }
    
    // relasi
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
