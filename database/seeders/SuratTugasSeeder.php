<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratTugas;
use Illuminate\Support\Facades\DB;

class SuratTugasSeeder extends Seeder
{
    public function run(): void
    {
        SuratTugas::truncate();

        $data = [
            ['nomor_surat' => '01/ST/PKK.DIY/II/2024', 'tanggal_surat' => '2024-02-26', 'tujuan' => 'Sri Herawati,SH,MSi', 'perihal' => '29/ST/PKK.DIY/X/2024'],
            ['nomor_surat' => '02/ST/PKK.DIY/III/2024', 'tanggal_surat' => '2024-03-05', 'tujuan' => "Dra.Kristiana Swasti,MSi\n Dra.Baskorowati", 'perihal' => "Undangan kegiatan pengembangan literasi politik melalui forum Perempuan.\n Tanggal : 6 Maret 2024\n Tempat : HOM Premiere Timoho"],
            ['nomor_surat' => '03/ST/PKK.DIY/III/2024', 'tanggal_surat' => '2024-03-14', 'tujuan' => 'Sri Herawati,SH,MSi', 'perihal' => "Permohonan juri penguatan kampung KB.\n Tanggal : 18 – 22 Maret 2024"],
            ['nomor_surat' => '04/ST/PKK.DIY/III/2024', 'tanggal_surat' => '2024-03-20', 'tujuan' => "Ray Sri Hapsasi S.P,SE\n Haryanti, Mpd\n Endang Kusumawati, S.Sos", 'perihal' => 'Perwakilan lomba uredo kreasi jingle gelari Pelangi adalah TP PKK Kab. Sleman.'],
            ['nomor_surat' => '05/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-07', 'tujuan' => "Wuri Astuti Marso\n Nurhani Jauhari,S.Gz\n Ery Murniasih, SIP", 'perihal' => "Peserta lomba cerdas cermat dalam rangka kegiatan jamboree nasional kader PKK tahun 2024\n Tanggal : 14 – 16 Mei 2024"],
            ['nomor_surat' => '06/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-08', 'tujuan' => 'Dra.Tatitk Ratnawati,MM', 'perihal' => "Sebagai narasumber kegiatan penguatan kapasitas dan kualitas penyuluh KB/PLKB\n Tanggal : 13 – 16 Mei 2024"],
            ['nomor_surat' => '07/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-09', 'tujuan' => 'Dr.Siswantiningsih,S.U', 'perihal' => "Sebagai narasumber kegiatan bimbingan perkawinan\n Tanggal : 14 – 15 Mei 2024"],
            ['nomor_surat' => '08/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-09', 'tujuan' => 'GKBRAY.Kuswarjanti Riyokusumo', 'perihal' => "Sebagai narasumber kegiatan bimbingan perkawinan\n Tanggal : 14 – 15 Mei 2024"],
            ['nomor_surat' => '09/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-09', 'tujuan' => 'Dra.I.M. Sunarsih Sutaryo,SU,Apt', 'perihal' => "Sebagai narasumber kegiatan bimbingan perkawinan\n Tanggal : 14 – 15 Mei 2024"],
            ['nomor_surat' => '10/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-13', 'tujuan' => 'GKBRAA.Paku Alam', 'perihal' => "Sebagai peserta jamboree nasional kader PKK tahun 2024\n Tanggal : 14 – 16 Mei 2024"],
            ['nomor_surat' => '11/ST/PKK.DIY/V/2024', 'tanggal_surat' => '2024-05-13', 'tujuan' => 'Dra.I.M. Sunarsih Sutaryo,SU,Apt', 'perihal' => "Sebagai peserta jamboree nasional kader PKK tahun 2024\n Tanggal : 14 – 16 Mei 2024"],
            ['nomor_surat' => '12/ST/PKK.DIY/VI/2024', 'tanggal_surat' => '2024-06-03', 'tujuan' => 'Atik Wulandari, SP', 'perihal' => "Sebagai peserta sekolah orang tua hebat ( SOTH)\n Tanggal : 3 – 8 Juni 2024"],
            ['nomor_surat' => '13/ST/PKK.DIY/VI/2024', 'tanggal_surat' => '2024-06-03', 'tujuan' => 'Sri Herawati, SH,MSi', 'perihal' => "Sebagai peserta sekolah orang tua hebat ( SOTH)\n Tanggal : 3 – 8 Juni 2024"],
            ['nomor_surat' => '14/ST/PKK.DIY/VI/2024', 'tanggal_surat' => '2024-06-12', 'tujuan' => 'Sri Mulyani', 'perihal' => "Sebagai peserta bimbingan teknis bagi kader poktan BKB\n Tanggal : 12 – 14 Juni 2024"],
            ['nomor_surat' => '15/ST/PKK.DIY/VI/2024', 'tanggal_surat' => '2024-06-12', 'tujuan' => 'Sugianti', 'perihal' => "Sebagai peserta bimbingan teknis bagi kader poktan BKB\n Tanggal : 12 – 14 Juni 2024"],
            ['nomor_surat' => '16/ST/PKK.DIY/VII/2024', 'tanggal_surat' => '2024-07-29', 'tujuan' => 'Dra.Kristiana Swasti, MSi', 'perihal' => "Sebagai narasumber kegiatan gerakan ayo ikut KB\n Tanggal : 30 Juli 2024"],
            ['nomor_surat' => '17/ST/PKK.DIY/VIII/2024', 'tanggal_surat' => '2024-08-13', 'tujuan' => 'Sri Herawati, SH,MSi', 'perihal' => "Sebagai narasumber kegiatan penguatan implementasi kebijakan ketahanan keluarga berbasis masyarakat\n Tanggal : 13 Agustus 2024"],
            ['nomor_surat' => '18/ST/PKK.DIY/VIII/2024', 'tanggal_surat' => '2024-08-13', 'tujuan' => 'Ir. Tri Martini', 'perihal' => "Sebagai peserta lomba paduan suara HUT RI Ke-79\n Tanggal : 13 Agustus 2024"],
            ['nomor_surat' => '19/ST/PKK.DIY/VIII/2024', 'tanggal_surat' => '2024-08-16', 'tujuan' => 'GKR.Hemas', 'perihal' => "Sebagai juri kehormatan lomba memasak dalam acara Gelar Potensi Pangan Lokal\n Tanggal : 16 Agustus 2024"],
            ['nomor_surat' => '20/ST/PKK.DIY/IX/2024', 'tanggal_surat' => '2024-09-02', 'tujuan' => 'Dra.Tatitk Ratnawati,MM', 'perihal' => "Sebagai narasumber dalam kegiatan bimbingan teknis program pemberdayaan ekonomi keluarga.\n Tanggal : 2 September 2024"],
            ['nomor_surat' => '21/ST/PKK.DIY/IX/2024', 'tanggal_surat' => '2024-09-02', 'tujuan' => 'Dra. Inni Lukmatin, M.Kes', 'perihal' => "Sebagai narasumber dalam kegiatan bimbingan teknis program pemanfaatan pekarangan sebagai sumber gizi.\n Tanggal : 2 September 2024"],
            ['nomor_surat' => '22/ST/PKK.DIY/IX/2024', 'tanggal_surat' => '2024-09-24', 'tujuan' => 'Ir.Astriani, M.Si', 'perihal' => "Surat tugas sebagai Pjs. Ketua TP PKK Kabupaten Bantul \n Tanggal : 25 September – 25 November 2024"],
            ['nomor_surat' => '23/ST/PKK.DIY/IX/2024', 'tanggal_surat' => '2024-09-24', 'tujuan' => 'Marzukoj,S.M', 'perihal' => "Surat tugas sebagai Pjs. Ketua TP PKK Kabupaten Gunungkidul.\n Tanggal : 25 September – 25 November 2024"],
            ['nomor_surat' => '24/ST/PKK.DIY/IX/2024', 'tanggal_surat' => '2024-09-25', 'tujuan' => 'Noor Hidayati ZP, S.Sos,M.Si', 'perihal' => "Surat tugas sebagai Pjs. Ketua TP PKK Kabupaten Sleman.\n Tanggal : 25 September – 25 November 2024"],
            ['nomor_surat' => '25/ST/PKK.DIY/X/2024', 'tanggal_surat' => '2024-10-21', 'tujuan' => 'Witriastuti S Anggraeni, S.E', 'perihal' => "Surat tugas sebagai pengurus TP PKK DIY khususnya Pokja IV & tugas TP PKK DIY lainya.\n Tanggal : 21 Oktober 2024"],
            ['nomor_surat' => '26/ST/PKK.DIY/X/2024', 'tanggal_surat' => '2024-10-21', 'tujuan' => 'Dara Kusumawati, SE,MM', 'perihal' => "Surat tugas sebagai pengurus TP PKK DIY khususnya secretariat bidang IT & tugas TP PKK DIY lainya.\n Tanggal : 21 Oktober 2024"],
            ['nomor_surat' => '27/ST/PKK.DIY/X/2024', 'tanggal_surat' => '2024-10-21', 'tujuan' => 'Nugraheni Sihwinanti, SH', 'perihal' => "Surat tugas sebagai pengurus TP PKK DIY khususnya Pokja I & tugas TP PKK DIY lainya.\n Tanggal : 21 Oktober 2024"],
            ['nomor_surat' => '28/ST/PKK.DIY/X/2024', 'tanggal_surat' => '2024-10-22', 'tujuan' => 'Ir. Tri Martini', 'perihal' => "Sebagai narasumber kegiatan penguatan kelembagaan pokja POK KB Desa.\n Tanggal : 22 Oktober 2024"],
            ['nomor_surat' => '29/ST/PKK.DIY/X/2024', 'tanggal_surat' => '2024-10-23', 'tujuan' => 'Ir. Aning Indrawati', 'perihal' => "Sebagai narasumber kegiatan program ketahanan pangan.\n Tanggal : 23 Oktober 2024"],
        ];

        // Memasukkan data dalam batch untuk performa yang lebih baik
        foreach ($data as $item) {
            SuratTugas::create($item);
        }
    }
}