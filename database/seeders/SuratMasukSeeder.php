<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\DB;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel untuk menghindari duplikasi
        SuratMasuk::truncate();

        $data = [
            ['penerima'=>'Unknown', 'nomor_surat' => '-', 'tanggal_surat' => '2022-01-12', 'tanggal_diterima' => '2022-01-13', 'pengirim' => 'Ibu Koesmini Wardono', 'perihal' => 'MENGUNDURKAN DIRI/MOHON PAMIT'],
            ['penerima'=>'Unknown', 'nomor_surat' => '-', 'tanggal_surat' => '2022-01-17', 'tanggal_diterima' => '2022-01-17', 'pengirim' => 'Teman Tupperware Manjakan Negri', 'perihal' => 'Acara Pelatihan Kewirausahaan dan Tata Boga untuk berbasis kalurahan'],
            ['penerima'=>'Unknown', 'nomor_surat' => '0284/PK01/02/J4/2022', 'tanggal_surat' => '2022-01-17', 'tanggal_diterima' => '2022-01-17', 'pengirim' => 'BKKbN DIY', 'perihal' => "Permohonan Narasumber\n Hari/tgl : Senin-jumat 24-28 Januari 2022\n Pukul : 08.30s/d selesai\n Tempat : Ruang Widya I Lat Bang Perwakilan BKKbN"],
            ['penerima'=>'Unknown', 'nomor_surat' => '06/SKR/PKK KEPRI/III/2022', 'tanggal_surat' => '2022-01-01', 'tanggal_diterima' => '2022-01-17', 'pengirim' => 'TP PKK Provinsi Kepulauan Riau', 'perihal' => "Kunjungan Kerja TP PKK Kepulauan Riau ke TP PKK DIY \n Hari/tgl :Jumat 21 Januari 2022"],
            ['penerima'=>'Unknown', 'nomor_surat' => '050/1205', 'tanggal_surat' => '2022-01-26', 'tanggal_diterima' => '2022-01-28', 'pengirim' => 'Pemda DIY', 'perihal' => "Undangan Konsultasi Publik\n Hari/tgl : Selasa 1 Februari 2022\n Pukul : 09.00\n Tempat : Gedung Pracimasono Kepatihan Yogyakarta"],
            ['penerima'=>'Unknown', 'nomor_surat' => '877/05981', 'tanggal_surat' => '2022-12-28', 'tanggal_diterima' => '2023-01-02', 'pengirim' => 'SETDA DIY', 'perihal' => "UNDANGAN.\n HARI/TANGGAL : RABU, 24 MEI 2023\n WAKTU     : PUKUL 11.00 WIB\n TEMPAT   : BANGSAL KEPATIHAN KOMPLEK KEPATIHAN YK\n ACARA     : PELANTIKAN PEJABAT PIMPINAN TINGGI PRATAMAN DI LINGKUNGAN PEMERINTAH DAERAH DIY\n PAKAIAN  : PAKAIAN SIPIL LENGKAP (TNI/POLRI PAKAIAN PDU TANPA TANDA JASA )"],
            ['penerima'=>'Unknown', 'nomor_surat' => '050/00080', 'tanggal_surat' => '2023-01-09', 'tanggal_diterima' => '2023-01-10', 'pengirim' => 'BIRO BINA GERMAS', 'perihal' => "UNDANGAN.\n HARI/TANGGAL : KAMIS, 12 JANUARI 2023\n WAKTU    : 13.00 WIB S/D SELESAI\n ACARA     : PELANTIKAN PEJABAT PIMPINAN TINGGI PRATAMAN DI LINGKUNGAN PEMERINTAH DAERAH DIY"],
            ['penerima'=>'Unknown', 'nomor_surat' => '463/12665', 'tanggal_surat' => '2023-11-29', 'tanggal_diterima' => '2023-11-29', 'pengirim' => 'DP3AP2', 'perihal' => 'PERMOHONAN PERSONIL & KLARIFIKASI ANGGOTA'],
            ['penerima'=>'Unknown', 'nomor_surat' => '109/PHI.DIY/I/2024', 'tanggal_surat' => '2024-01-04', 'tanggal_diterima' => '2024-01-04', 'pengirim' => 'PHI KE-95', 'perihal' => "UNDANGAN PEMBUBARAN PANITIA\n 8 JANUARI 2024 10.30 WIB\n RESTO PAWON MBAH GITO"],
            ['penerima'=>'Unknown', 'nomor_surat' => '400.7.6/44', 'tanggal_surat' => '2024-01-08', 'tanggal_diterima' => '2024-01-08', 'pengirim' => 'RO BINA MENTAL', 'perihal' => "PERMOHONAN PENGISIAN MATRIKS KERJA\n PROGRAM & KEGIATAN RAD KESWA DIY"],
            ['penerima'=>'Unknown', 'nomor_surat' => '500.1.16/28105', 'tanggal_surat' => '2024-12-12', 'tanggal_diterima' => '2024-12-18', 'pengirim' => 'DPKP', 'perihal' => "Undangan Pelaksanaan Kegiatan Rumah Pangan Beragam Bergizi Seimbang dan Aman ( B2SA ) tahun 2024\n Hari/tanggal :  Kamis, 19 Desember 2024\n Tempat :  Ruang Rapat Flamboyan"],
            ['penerima'=>'Unknown', 'nomor_surat' => 'B/400.2/3/018', 'tanggal_surat' => '2025-01-02', 'tanggal_diterima' => '2025-01-02', 'pengirim' => 'DP3AP2 DIY', 'perihal' => 'Ucapan Terimakasih atas kontribusi peringatan HAKPTA tahun 2024'],
            ['penerima'=>'Unknown', 'nomor_surat' => '400.14.1.1/9328', 'tanggal_surat' => '2024-12-31', 'tanggal_diterima' => '2025-01-02', 'pengirim' => 'PEMDA DIY', 'perihal' => "Undangan Upacara Pengukuhan Pelantikan & Pengambilan sumpah  Jabatan Pimpinan Madya, Pimpinan tinggi dsbg.\n Hari/tanggal: Jum'at, 03  Januari 2025\n Jam : 09.00 WIB-Selesai\n Tempat : Bangsal Kepatihan Yogyakarta "],
            ['penerima'=>'Unknown', 'nomor_surat' => '075/05/TPPS/VI/2025', 'tanggal_surat' => '2025-06-16', 'tanggal_diterima' => '2025-06-20', 'pengirim' => 'TPPS DIY', 'perihal' => "Undangan Rapat Koordinasi TPPS DIY\n Hari/Tanggal : Rabu, 25 Juni 2025\n Pukul : 13.00 WIB s,d Selesai \n Tempat : Ruang Widya 1, Perwakilan BKKBN DIY\n Jl. Kenari No 58 (Timoho) Yogyakarta\n Agenda : Penyampaikan Progres Program dari Masing-Masing Bidang TPPS DIY Semester 1 Tahun 2025 Sebagai Bahan Laporan TPPS DIY"],
        ];

        // Memasukkan data dalam batch untuk performa yang lebih baik
        foreach (array_chunk($data, 200) as $chunk) {
            SuratMasuk::insert($chunk);
        }
    }
}