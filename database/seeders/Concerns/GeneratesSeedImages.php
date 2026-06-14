<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait GeneratesSeedImages
{
    /**
     * Buat satu gambar placeholder (gradient warna + lingkaran dekoratif + label)
     * memakai ekstensi GD, menyimpannya ke disk "public" pada folder seed/, lalu
     * mengembalikan path relatifnya (mis. "seed/abc123.jpg"). Path ini berformat
     * sama dengan hasil upload sehingga langsung bisa dirender lewat /storage/<path>.
     */
    protected function makeSeedImage(string $label, int $variant = 0, int $width = 1200, int $height = 800): string
    {
        // Pasangan warna (atas, bawah) untuk gradient — dipilih berdasarkan $variant
        $palettes = [
            [[14, 165, 233], [3, 105, 161]],
            [[13, 118, 182], [12, 74, 110]],
            [[16, 185, 129], [6, 95, 70]],
            [[249, 115, 22], [154, 52, 18]],
            [[168, 85, 247], [88, 28, 135]],
            [[236, 72, 153], [131, 24, 67]],
            [[245, 158, 11], [146, 64, 14]],
            [[6, 182, 212], [21, 94, 117]],
            [[99, 102, 241], [55, 48, 163]],
            [[20, 184, 166], [17, 94, 89]],
        ];
        [$from, $to] = $palettes[$variant % count($palettes)];

        $img = imagecreatetruecolor($width, $height);
        imagealphablending($img, true);

        // Gradient vertikal
        for ($y = 0; $y < $height; $y++) {
            $t = $y / max(1, $height - 1);
            $color = imagecolorallocate(
                $img,
                (int) round($from[0] + ($to[0] - $from[0]) * $t),
                (int) round($from[1] + ($to[1] - $from[1]) * $t),
                (int) round($from[2] + ($to[2] - $from[2]) * $t),
            );
            imageline($img, 0, $y, $width, $y, $color);
        }

        // Lingkaran putih transparan sebagai aksen
        $circles = [
            [$width * 0.18, $height * 0.30, 360, 110],
            [$width * 0.82, $height * 0.72, 460, 75],
            [$width * 0.70, $height * 0.18, 200, 95],
        ];
        foreach ($circles as [$cx, $cy, $diameter, $alpha]) {
            $soft = imagecolorallocatealpha($img, 255, 255, 255, $alpha);
            imagefilledellipse($img, (int) $cx, (int) $cy, (int) $diameter, (int) $diameter, $soft);
        }

        // Label di tengah (memakai font bawaan GD terbesar)
        $font = 5;
        $text = strtoupper($label);
        $textWidth = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);
        $x = (int) (($width - $textWidth) / 2);
        $y = (int) (($height - $textHeight) / 2);
        $shadow = imagecolorallocatealpha($img, 0, 0, 0, 75);
        $white = imagecolorallocate($img, 255, 255, 255);
        imagestring($img, $font, $x + 2, $y + 2, $text, $shadow);
        imagestring($img, $font, $x, $y, $text, $white);

        ob_start();
        imagejpeg($img, null, 85);
        $contents = ob_get_clean();
        imagedestroy($img);

        $path = 'seed/' . Str::random(40) . '.jpg';
        Storage::disk('public')->put($path, $contents);

        return $path;
    }
}
