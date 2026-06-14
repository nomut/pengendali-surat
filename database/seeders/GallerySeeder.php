<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Database\Seeders\Concerns\GeneratesSeedImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    use GeneratesSeedImages;

    public function run(): void
    {
        // [judul, deskripsi]
        $items = [
            ['Dokumentasi Pelatihan Menjahit', 'Kumpulan foto kegiatan pelatihan keterampilan menjahit bagi ibu rumah tangga.'],
            ['Kegiatan Posyandu Balita', 'Momen pelayanan posyandu dan pemeriksaan kesehatan balita di wilayah binaan.'],
            ['Lomba Masak Menu Sehat', 'Keseruan lomba masak menu sehat berbahan pangan lokal antarkader PKK.'],
            ['Gerakan Tanam Pekarangan', 'Dokumentasi gerakan menanam sayur dan tanaman obat keluarga di pekarangan rumah.'],
            ['Bakti Sosial Pembagian Sembako', 'Foto kegiatan bakti sosial dan penyaluran paket sembako kepada warga.'],
            ['Senam Sehat Bersama', 'Antusiasme kader PKK dalam kegiatan senam sehat yang digelar rutin.'],
            ['Workshop Kewirausahaan UMKM', 'Suasana pelatihan kewirausahaan dan pendampingan UMKM keluarga.'],
            ['Peringatan Hari Kesatuan Gerak PKK', 'Rangkaian acara dan kemeriahan peringatan Hari Kesatuan Gerak PKK.'],
            ['Pelatihan Daur Ulang Sampah', 'Hasil karya dan proses pelatihan pengolahan sampah menjadi kerajinan.'],
            ['Penyuluhan Kesehatan Keluarga', 'Dokumentasi penyuluhan kesehatan dan pencegahan stunting bagi keluarga.'],
            ['Kunjungan Kerja dan Pembinaan', 'Foto kegiatan kunjungan kerja serta pembinaan kader di tingkat kecamatan.'],
            ['Pameran Produk UMKM Binaan', 'Aneka produk unggulan UMKM binaan PKK yang ditampilkan dalam pameran.'],
            ['Gotong Royong Lingkungan', 'Kebersamaan warga dalam kegiatan gotong royong membersihkan lingkungan.'],
            ['Pelatihan Pola Asuh Anak', 'Suasana pelatihan pola asuh anak di era digital bersama para orang tua.'],
            ['Rapat Koordinasi Tim Penggerak', 'Dokumentasi rapat koordinasi rutin Tim Penggerak PKK Daerah Istimewa Yogyakarta.'],
        ];

        foreach ($items as $i => [$title, $description]) {
            $date = Carbon::now()->subDays(($i + 1) * 16);

            $images = [];
            $jumlahFoto = random_int(4, 6);
            for ($n = 1; $n <= $jumlahFoto; $n++) {
                $images[] = $this->makeSeedImage('Foto ' . $n, $i + $n);
            }

            Gallery::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'description' => $description,
                    'date' => $date->toDateString(),
                    'images' => $images,
                    'is_published' => ! in_array($i, [6, 13], true),
                ]
            );
        }
    }
}
