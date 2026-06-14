<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Beranda',
                'content' => '<h1>PKK DIY Teguhkan Komitmen Menuju Indonesia Emas</h1>
<p>Terwujudnya Keluarga Beriman dan Bertaqwa kepada Tuhan Yang Maha Esa, Berakhlak Mulia, dan Berbudi Luhur, Sehat, Sejahtera, Maju, Mandiri, Kesetaraan dan Keadilan Gender, serta Kesadaran Hukum dan Lingkungan.</p>',
                'meta' => [
                    'kelompok_kerja' => [
                        [
                            'title' => 'Pembinaan Karakter Keluarga',
                            'description' => 'Pembinaan karakter keluarga berfokus pada penguatan nilai moral, etika, dan budaya luhur dalam keluarga. Programnya mendorong pola asuh positif, ketahanan keluarga, serta peran orang tua dalam pendidikan karakter anak, sehingga keluarga menjadi dasar pembentukan generasi yang berakhlak mulia, tangguh, dan harmonis.',
                        ],
                        [
                            'title' => 'Pendidikan Dan Peningkatan Ekonomi Keluarga',
                            'description' => 'Bidang Pendidikan dan Peningkatan Ekonomi Keluarga berupaya meningkatkan kualitas sumber daya manusia serta kemandirian ekonomi keluarga. Program yang dijalankan mencakup penguatan pendidikan nonformal, pelatihan keterampilan, serta pemberdayaan usaha mikro dan rumah tangga.',
                        ],
                        [
                            'title' => 'Penguatan Ketahanan Keluarga',
                            'description' => 'Penguatan Ketahanan Keluarga berfokus pada upaya membangun keluarga yang sehat, harmonis, dan tangguh menghadapi tantangan zaman. Programnya meliputi peningkatan kualitas hubungan antaranggota keluarga, kesehatan jasmani dan rohani, serta kesadaran akan pentingnya lingkungan yang aman dan nyaman.',
                        ],
                        [
                            'title' => 'Kesehatan Keluarga Dan Lingkungan',
                            'description' => 'Kesehatan Keluarga dan Lingkungan berkomitmen meningkatkan kualitas hidup masyarakat dengan mendorong perilaku hidup bersih dan sehat. Programnya mencakup edukasi gizi, kesehatan ibu dan anak, pencegahan penyakit, serta pengelolaan lingkungan yang bersih dan ramah.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'profil-organisasi',
                'title' => 'Profil Organisasi',
                'content' => '<h2>Sejarah Singkat</h2>
<p>Gerakan Pemberdayaan dan Kesejahteraan Keluarga (PKK) sebagai gerakan pembangunan masyarakat bermula dari seminar Home Economic di Bogor pada tahun 1957. Sebagai tindak lanjut dari seminar tersebut, pada tahun 1961 panitia penyusunan tata susunan pelajaran pada Pendidikan Kesejahteraan Keluarga (PKK) Kementerian Pendidikan.</p>
<p>Di Daerah Istimewa Yogyakarta, gerakan ini telah menjadi tulang punggung dalam upaya peningkatan kualitas hidup keluarga, adaptif terhadap perubahan zaman, dan terus berinovasi untuk memberdayakan perempuan dan masyarakat secara luas.</p>',
                'meta' => [
                    'visi' => 'Terwujudnya keluarga yang beriman dan bertaqwa kepada Tuhan Yang Maha Esa, berakhlak mulia dan berbudi luhur, sehat sejahtera, maju dan mandiri, kesetaraan dan keadilan gender serta kesadaran hukum dan lingkungan.',
                    'misi' => 'Meningkatkan kualitas sumber daya manusia, memperkuat ketahanan ekonomi keluarga, serta melestarikan lingkungan hidup sambil meningkatkan kesadaran hukum dan partisipasi masyarakat.',
                ],
            ],
            [
                'slug' => 'struktur-organisasi',
                'title' => 'Struktur Organisasi',
                'content' => '<p>Tim Penggerak Pemberdayaan dan Kesejahteraan Keluarga Daerah Istimewa Yogyakarta.</p>',
                'meta' => [
                    'ketua_dan_wakil' => [
                        ['nama' => 'GUSTI KANJENG RATU HEMAS', 'jabatan' => 'KETUA TP PKK'],
                        ['nama' => 'GKBRAA PAKU ALAM', 'jabatan' => 'WAKIL KETUA TP PKK'],
                    ],
                    'penasehat' => [
                        ['nama' => 'GKBRAY. KUSWARJANTI RIYOKUSUMO'],
                        ['nama' => 'Dr. Dra. I. M. SUNARSIH SUTARYO, SU, Apt'],
                        ['nama' => 'Dr. SISWATININGSIH. SU'],
                    ],
                    'bendahara' => [['nama' => 'SUGIANTI']],
                    'sekertaris' => [
                        ['nama' => 'M.ANGGRAINI ADRIANI', 'jabatan' => 'SEKERTARIS'],
                        ['nama' => 'IR. TRI MARTINI', 'jabatan' => 'SEKERTARIS I', 'sub' => 'URUSAN PERENCANAAN'],
                        ['nama' => 'DARA KUSUMAWATI, SE, MM', 'jabatan' => 'SEKERTARIS II', 'sub' => 'URUSAN HUMAS & IT'],
                        ['nama' => 'NUGRAHENI SIH WINANTI, SH', 'jabatan' => 'SEKERTARIS III', 'sub' => 'URUSAN UMUM'],
                    ],
                    'ketua_bidang' => [
                        ['nama' => 'Dra. KRISTIANA SWASTI, MSi', 'jabatan' => 'KETUA 1', 'sub' => 'PEMBINAAN KARAKTER KELUARGA'],
                        ['nama' => 'Dra. TATIK RATNAWATI, MM', 'jabatan' => 'KETUA II', 'sub' => 'PENDIDIKAN DAN PENINGKATAN EKONOMI KELUARGA'],
                        ['nama' => 'T.O SUPRAPTO', 'jabatan' => 'KETUA III', 'sub' => 'PENGUATAN KETAHANAN KELUARGA'],
                        ['nama' => 'Drg. INNI HIKMATIN M.Kes', 'jabatan' => 'KETUA IV', 'sub' => 'KESEHATAN KELUARGA DAN LINGKUNGAN'],
                    ],
                    'pokja' => [
                        [
                            'nama' => 'POKJA I',
                            'anggota' => [
                                ['nama' => 'ATIK WULANDARI, SP', 'jabatan' => 'KETUA'],
                                ['nama' => 'Dra. BASKOROWATI', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'TRI SUNDARI', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'SURYANTINAH, SIP, MM', 'jabatan' => 'ANGGOTA'],
                            ],
                        ],
                        [
                            'nama' => 'POKJA II',
                            'anggota' => [
                                ['nama' => 'TUTIK MULYANTO, S.Sos', 'jabatan' => 'KETUA'],
                                ['nama' => 'SUPRIHATININGSHI', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'PUJI ASTUTI', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'YURRY APRITO', 'jabatan' => 'ANGGOTA'],
                            ],
                        ],
                        [
                            'nama' => 'POKJA III',
                            'anggota' => [
                                ['nama' => 'RUKIWIYATI', 'jabatan' => 'KETUA'],
                                ['nama' => 'Ir. INDIYAH WIDNINGSIH', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'SRI SUKARNI SUWARDI', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'IR. ANING INDRAWATI', 'jabatan' => 'ANGGOTA'],
                            ],
                        ],
                        [
                            'nama' => 'POKJA IV',
                            'anggota' => [
                                ['nama' => 'SRI HERAWATI, SH, MSI', 'jabatan' => 'KETUA'],
                                ['nama' => 'SRI HARTATI, SKM, M.Kes', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'WITRI ASTUTI ANGGRASNI, SE', 'jabatan' => 'ANGGOTA'],
                                ['nama' => 'SRI MUKTISUNARDINI, SKM, M.Kes', 'jabatan' => 'ANGGOTA'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'pokja-1',
                'title' => 'Pokja I - Pembinaan Karakter Keluarga',
                'content' => '<h2>PROGRAM POKJA I</h2>
<h3>Program Penghayatan dan Pengamalan Pancasila</h3>
<p>Program ini dilaksanakan dengan cara:</p>
<ul>
<li>Pembinaan karakter Keluarga.</li>
<li>Pembinaan karakter anak sejak dini.</li>
<li>Pembinaan peran orang tua dalam menerapkan pola asuh anak dan remaja di era digital.</li>
<li>Pencegahan perkawinan anak dibawah umur khususnya anak perempuan.</li>
<li>Pembinaan Keluarga sadar administrasi kependudukan.</li>
<li>Pembinaan kesadaran bela negara.</li>
<li>Pembinaan pencegahan penyalahagunaan narkoba.</li>
<li>Pembinaan pencegahan kekerasan dalam rumah tangga.</li>
<li>Pembinaan pencegahan perdagangan manusia.</li>
<li>Pembinaan pencegahan kekerasan seksual terhadap anak.</li>
</ul>
<h3>Program Gotong Royong</h3>
<p>Program ini dilaksanakan dengan cara:</p>
<ul>
<li>Menumbuhkan sikap kesetiakawanan sosial.</li>
<li>Pemberdayaan lanjut usia.</li>
<li>Pemberdayaan penyandang disabilitas.</li>
<li>Partisipasi dalam kegiatan bakti sosial di masyarakat.</li>
<li>Pencegahan kekerasan seksual pada anak dan perempuan.</li>
<li>Pencegahan praktek perdagangan manusia.</li>
<li>Pembinaan keluarga Indonesia bebas narkoba.</li>
</ul>',
                'meta' => [
                    'subtitle' => 'Fokus pada Penghayatan dan Pengamalan Pancasila serta Gotong Royong.',
                ],
            ],
            [
                'slug' => 'pokja-2',
                'title' => 'Pokja II - Pendidikan dan Peningkatan Ekonomi Keluarga',
                'content' => '<h2>PROGRAM POKJA II</h2>
<h3>Program Pendidikan dan Keterampilan</h3>
<p>Meningkatkan kualitas pendidikan nonformal dan keterampilan keluarga untuk mendukung kemandirian ekonomi.</p>
<h3>Program Pengembangan Kehidupan Berkoperasi</h3>
<p>Mendorong terbentuknya koperasi dan usaha kecil yang mandiri berbasis keluarga.</p>',
                'meta' => [
                    'subtitle' => 'Fokus pada Pendidikan dan Keterampilan serta Pengembangan Kehidupan Berkoperasi.',
                ],
            ],
            [
                'slug' => 'pokja-3',
                'title' => 'Pokja III - Penguatan Ketahanan Keluarga',
                'content' => '<h2>PROGRAM POKJA III</h2>
<h3>Program Pangan</h3>
<p>Meningkatkan ketahanan pangan keluarga melalui diversifikasi pangan dan pemanfaatan pekarangan.</p>
<h3>Program Sandang</h3>
<p>Mendorong pengembangan industri sandang rumahan dan pelestarian budaya berpakaian.</p>
<h3>Program Perumahan Dan Tata Laksana Rumah Tangga</h3>
<p>Pembinaan keluarga dalam penataan dan pemeliharaan rumah tangga yang sehat dan nyaman.</p>',
                'meta' => [
                    'subtitle' => 'Fokus pada Pangan, Sandang, dan Perumahan serta Tata Laksana Rumah Tangga.',
                ],
            ],
            [
                'slug' => 'pokja-4',
                'title' => 'Pokja IV - Kesehatan Keluarga dan Lingkungan',
                'content' => '<h2>PROGRAM POKJA IV</h2>
<h3>Program Kesehatan</h3>
<p>Meningkatkan derajat kesehatan keluarga melalui pembinaan kesehatan ibu dan anak, gizi, serta pencegahan penyakit.</p>
<h3>Program Kelestarian Lingkungan Hidup</h3>
<p>Mendorong kesadaran keluarga dalam pengelolaan sampah, penghijauan, dan pelestarian lingkungan hidup.</p>
<h3>Program Perencanaan Sehat</h3>
<p>Pembinaan keluarga berencana dan kesehatan reproduksi.</p>',
                'meta' => [
                    'subtitle' => 'Fokus pada Kesehatan, Kelestarian Lingkungan Hidup, dan Perencanaan Sehat.',
                ],
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
