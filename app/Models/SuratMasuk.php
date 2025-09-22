<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'penerima',
        'pengirim',
        'tanggal_diterima',
        'tanggal_surat',
        'nomor_surat',
        'perihal',
        'lampiran',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_terima' => 'datetime',
            'tanggal_surat' => 'datetime',
        ];
    }
}
