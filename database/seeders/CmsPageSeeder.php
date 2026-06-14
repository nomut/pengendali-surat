<?php

namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Concerns\GeneratesSeedImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsPageSeeder extends Seeder
{
    use GeneratesSeedImages;

    /**
     * Halaman konten/artikel umum untuk CMS. Halaman struktural khusus
     * (home, profil-organisasi, struktur-organisasi, pokja-*) tetap diisi
     * oleh PageSeeder. Seeder ini menambahkan 15 halaman informasi yang
     * masing-masing memiliki gambar utama (meta.main_image).
     */
    public function run(): void
    {
        // [judul, ringkasan/pembuka]
        $items = [
            ['Tips Menjaga Kesehatan Keluarga Sehari-hari', 'Kesehatan keluarga dimulai dari kebiasaan sederhana yang dilakukan setiap hari di rumah.'],
            ['Panduan Hidup Bersih dan Sehat di Rumah', 'Menerapkan Perilaku Hidup Bersih dan Sehat (PHBS) adalah langkah awal menuju keluarga yang sehat.'],
            ['Mengenal 10 Program Pokok PKK', '10 Program Pokok PKK menjadi pedoman gerakan pemberdayaan dan kesejahteraan keluarga.'],
            ['Cara Bijak Mengelola Keuangan Rumah Tangga', 'Pengelolaan keuangan yang baik membantu keluarga mencapai kesejahteraan dan kemandirian ekonomi.'],
            ['Manfaat Tanaman Obat Keluarga (TOGA)', 'TOGA memberi banyak manfaat kesehatan sekaligus mempercantik pekarangan rumah.'],
            ['Pentingnya Imunisasi Lengkap bagi Anak', 'Imunisasi lengkap melindungi anak dari berbagai penyakit berbahaya sejak dini.'],
            ['Pola Asuh Positif untuk Tumbuh Kembang Anak', 'Pola asuh yang positif berperan besar dalam membentuk karakter dan tumbuh kembang anak.'],
            ['Mengolah Sampah Rumah Tangga Menjadi Berkah', 'Sampah rumah tangga dapat dikelola menjadi sesuatu yang bermanfaat dan bernilai ekonomi.'],
            ['Inspirasi Menu Sehat dan Bergizi untuk Keluarga', 'Menyajikan menu sehat dan bergizi tidak harus mahal, cukup memanfaatkan bahan pangan lokal.'],
            ['Peran Perempuan dalam Pembangunan Daerah', 'Perempuan memiliki peran strategis dalam mendorong pembangunan di tingkat keluarga dan masyarakat.'],
            ['Mencegah Pernikahan Dini di Lingkungan Keluarga', 'Pencegahan pernikahan dini menjadi tanggung jawab bersama demi masa depan anak yang lebih baik.'],
            ['Membangun Ketahanan Pangan dari Pekarangan', 'Pekarangan rumah dapat menjadi sumber pangan keluarga yang sehat dan berkelanjutan.'],
            ['Edukasi Bahaya Narkoba bagi Generasi Muda', 'Memberikan edukasi sejak dini adalah kunci melindungi generasi muda dari bahaya narkoba.'],
            ['Menumbuhkan Semangat Gotong Royong di Masyarakat', 'Gotong royong adalah modal sosial yang memperkuat kebersamaan dan kepedulian antarwarga.'],
            ['Literasi Digital untuk Keluarga Modern', 'Literasi digital membantu keluarga memanfaatkan teknologi secara bijak dan aman.'],
        ];

        foreach ($items as $i => [$title, $intro]) {
            Page::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'content' => $this->buildContent($title, $intro),
                    'meta' => [
                        'main_image' => $this->makeSeedImage('Halaman ' . ($i + 1), $i),
                    ],
                ]
            );
        }
    }

    private function buildContent(string $title, string $intro): string
    {
        return <<<HTML
<p>{$intro}</p>
<h2>{$title}</h2>
<p>Tim Penggerak PKK Daerah Istimewa Yogyakarta berkomitmen untuk terus memberikan informasi dan edukasi yang bermanfaat bagi keluarga. Halaman ini menyajikan ulasan ringkas yang dapat menjadi rujukan dalam kehidupan sehari-hari.</p>
<h3>Poin Penting</h3>
<ul>
<li>Mulai dari langkah kecil yang konsisten di lingkungan keluarga.</li>
<li>Libatkan seluruh anggota keluarga agar manfaatnya lebih terasa.</li>
<li>Sebarkan informasi positif ini kepada tetangga dan masyarakat sekitar.</li>
</ul>
<p>Semoga informasi ini bermanfaat dan dapat mendukung terwujudnya keluarga yang sehat, sejahtera, dan mandiri.</p>
HTML;
    }
}
