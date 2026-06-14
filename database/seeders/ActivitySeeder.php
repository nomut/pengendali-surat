<?php

namespace Database\Seeders;

use App\Models\Activity;
use Database\Seeders\Concerns\GeneratesSeedImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    use GeneratesSeedImages;

    public function run(): void
    {
        // [judul, ringkasan]
        $items = [
            ['Pelatihan Keterampilan Menjahit bagi Ibu Rumah Tangga', 'Membekali ibu rumah tangga dengan keterampilan menjahit untuk mendukung kemandirian ekonomi keluarga.'],
            ['Sosialisasi Gizi Seimbang dan Pencegahan Stunting', 'Edukasi pentingnya gizi seimbang sejak dini sebagai upaya bersama mencegah stunting di lingkungan keluarga.'],
            ['Gerakan Tanam Sayur di Pekarangan Rumah', 'Memanfaatkan lahan pekarangan untuk menanam sayuran guna menunjang ketahanan pangan keluarga.'],
            ['Posyandu Balita dan Pemeriksaan Kesehatan Gratis', 'Layanan penimbangan, imunisasi, serta pemeriksaan kesehatan gratis bagi balita di wilayah binaan.'],
            ['Lomba Masak Menu Sehat Berbahan Pangan Lokal', 'Kreativitas kader PKK diuji dalam mengolah menu sehat dan bergizi berbahan pangan lokal.'],
            ['Penyuluhan Bahaya Narkoba bagi Remaja', 'Memberikan pemahaman kepada remaja tentang bahaya penyalahgunaan narkoba dan cara menghindarinya.'],
            ['Pelatihan Pembuatan Kerajinan Daur Ulang', 'Mengubah sampah rumah tangga menjadi produk kerajinan bernilai jual sekaligus menjaga lingkungan.'],
            ['Bakti Sosial dan Pembagian Sembako', 'Kegiatan kepedulian sosial berupa pembagian paket sembako kepada keluarga prasejahtera.'],
            ['Senam Sehat Bersama Kader PKK', 'Membudayakan hidup sehat melalui senam bersama yang rutin diikuti para kader PKK.'],
            ['Workshop Kewirausahaan UMKM Keluarga', 'Mendorong tumbuhnya usaha mikro keluarga melalui pelatihan kewirausahaan dan pemasaran digital.'],
            ['Pembinaan Keluarga Sadar Hukum (Kadarkum)', 'Meningkatkan kesadaran hukum keluarga agar tercipta masyarakat yang tertib dan harmonis.'],
            ['Penyuluhan Pola Asuh Anak di Era Digital', 'Membekali orang tua dengan strategi pengasuhan yang tepat di tengah pesatnya teknologi digital.'],
            ['Gerakan Pemberantasan Sarang Nyamuk (PSN)', 'Aksi serentak membersihkan lingkungan untuk mencegah penyebaran penyakit demam berdarah.'],
            ['Pelatihan Pengolahan Sampah Rumah Tangga', 'Mengajarkan pemilahan dan pengolahan sampah rumah tangga secara mandiri dan berkelanjutan.'],
            ['Peringatan Hari Kesatuan Gerak PKK ke-53', 'Rangkaian acara memperingati Hari Kesatuan Gerak PKK sebagai momentum penguatan organisasi.'],
        ];

        foreach ($items as $i => [$title, $excerpt]) {
            $date = Carbon::now()->subDays(($i + 1) * 13);

            Activity::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'content' => $this->buildContent($title, $excerpt, $date),
                    'cover_image' => $this->makeSeedImage('Kegiatan ' . ($i + 1), $i),
                    'date' => $date->toDateString(),
                    'is_published' => ! in_array($i, [5, 11], true),
                    'views' => random_int(24, 1280),
                ]
            );
        }
    }

    private function buildContent(string $title, string $excerpt, Carbon $date): string
    {
        $tanggal = $date->locale('id')->translatedFormat('d F Y');

        return <<<HTML
<p>{$excerpt}</p>
<p>Kegiatan <strong>{$title}</strong> dilaksanakan pada {$tanggal} dan diikuti oleh kader serta anggota Tim Penggerak PKK dari berbagai wilayah. Acara berlangsung penuh antusias dan menjadi ruang berbagi pengalaman antaranggota.</p>
<h3>Tujuan Kegiatan</h3>
<ul>
<li>Meningkatkan keterampilan dan pengetahuan anggota keluarga.</li>
<li>Mempererat kebersamaan dan gotong royong antarwarga.</li>
<li>Mendukung program pemberdayaan dan kesejahteraan keluarga.</li>
</ul>
<p>Melalui kegiatan ini diharapkan manfaatnya dapat dirasakan langsung oleh masyarakat dan menjadi inspirasi bagi pelaksanaan program serupa di masa mendatang.</p>
HTML;
    }
}
