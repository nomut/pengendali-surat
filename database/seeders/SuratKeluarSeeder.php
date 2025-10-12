<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\DB;

class SuratKeluarSeeder extends Seeder
{
    public function run(): void
    {
        SuratKeluar::truncate();

        $data = [
            ['nomor_surat' => '01/SKR/PKK.DIY/1/2023', 'tanggal_surat' => '2023-01-03', 'tujuan' => 'IBU-IBU ANGGOTA HARIAN TP PKK DIY', 'perihal' => "UNDANGAN \n HARI/TANGGAL : JUMAT, 6 JANUARI 2023\n PUKUL                 : 09.00 WIB\n TEMPAT               : KANTOR TP PKK DIY \n ACARA                : 1. PENGARAHAN WAKIL KETUA 1 TP PKK DIY TENTANG KAJIAN 2023\n                                2. PERSIAPAN RAKON USULAN PROGRAM TH 2024 YANG BERSINERGI DENGAN OPD"],
            ['nomor_surat' => '02/SKR/PKK.DIY/1/2023', 'tanggal_surat' => '2023-01-09', 'tujuan' => 'UNDANGAN TERLAMPIR', 'perihal' => "UNDANGAN RAKON \n HARI/TANGGAL : SENIN, 16 JANUARI 2023\n PUKUL                 : 09.00 - 12.00 WIB \n TEMPAT               : KANTOR TP PKK DIY \n ACARA                 : RAPAT KONSULTASI TENTANG DUKUNGAN TERHADAP USULAN PROGRAM DAN KEGIATAN TP PKK DIY TAHUN 2024"],
            ['nomor_surat' => '167/POKJA IV/PKK DIY/XII/2023', 'tanggal_surat' => '2024-12-11', 'tujuan' => 'TP PKK BANTUL, TP PKK KP', 'perihal' => "UNDANGAN SINERGITAS & PENGUATAN PROGRAM BANGGA KENCANA & PERCEPATAN PENURUNAN STUNTING\n HARI/TANGGAL   :  RABU, 13  DESEMBER   2023"],
            ['nomor_surat' => '01/POKJA IV/PKK.DIY/I/2024', 'tanggal_surat' => '2024-01-02', 'tujuan' => 'TP PKK KAB /KOTA SE-DIY', 'perihal' => "UNDANGAN RAKOR POKJA IV SE-DIY\n HARI/TANGGAL   : SELASA, 9 JANUARI 2024\n PUKUL                  : 09.00 WIB\n TEMPAT                : RUMAH MAKAN PATMO"],
            ['nomor_surat' => '02/POKJA III/PKK.DIY/I/2024', 'tanggal_surat' => '2024-01-18', 'tujuan' => 'KETUA TP PKK KAB/KOTA SE-DIY', 'perihal' => "UNDANGAN RAKOR PERSIAPAN LOMB MASAK\n HARI/TANGGAL  : SENIN, 22 JANUARI 2024\n PUKUL                : 09.00 WIB s.d Selesai\n TEMPAT              : KANTOR TP PKK DIY "],
            ['nomor_surat' => '195/Skr/PKK DIY/XII/2024', 'tanggal_surat' => '2024-12-12', 'tujuan' => 'KETUA PHI KE-96', 'perihal' => "PERMOHONAN TANDA TANGAN PIAGAM\n HARI IBU"],
            ['nomor_surat' => '01/POKJA 1/PKK.DIY/I/2025', 'tanggal_surat' => '2025-01-06', 'tujuan' => 'SELURUH KETUA TP PKK KAB & KOTA', 'perihal' => "UNDANGAN RAKOR 1 SE- DIY\n HARI/TANGGAL : SELASA, 7 JANUARI 2025\n PUKUL                 : 09.00 WIB - SELESAI\n TEMPAT               : GRIYA HINGGIL RESTO YOGYAKARTA"],
            ['nomor_surat' => '02/POKJA 3/PKK.DIY/I/2025', 'tanggal_surat' => '2025-01-06', 'tujuan' => 'SELURUH KETUA TP PKK KAB & KOTA', 'perihal' => "UNDANGAN RAPAT KOORDINASI POKJA 3 SE- DIY\n HARI/TANGGAL : SELASA, 14 JANUARI 2025\n PUKUL                 : 09.00 WIB - SELESAI\n TEMPAT               : TAMAN JAMU NATURINDO"],
            ['nomor_surat' => '86/POKJA 2/PKK.DIY/VI/2025', 'tanggal_surat' => '2025-06-30', 'tujuan' => "- KEPALA DPAD DIY\n- PIMPINAN PT BANK BPD DIY", 'perihal' => "UNDANGAN ACARA PELAKSANAAN LOMBA STORY TELLING (BERTUTUR)\n HARI/TANGGAL                      : KAMIS, 3 JULI 2025\n PUKUL                                       : 08.00 WIB - SELESAI\n TEMPAT                                     : GEDUNG GRHATAMA PUSTAKA"],
        ];

        foreach (array_chunk($data, 200) as $chunk) {
            SuratKeluar::insert($chunk);
        }
    }
}