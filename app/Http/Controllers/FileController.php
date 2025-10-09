<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Menyimpan file yang diunggah dan mengembalikan detailnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,webp,xls,xlsx,zip|max:20480',
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('attachments');
        
        $file = File::create([
            'path' => $path,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'mime_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
        ]);

        return response()->json($file);
    }

    public function destroy(File $file)
    {
        // Pastikan file belum terasosiasi dengan record lain,
        // atau tambahkan logic otorisasi di sini.
        
        Storage::disk('public')->delete($file->path);
        $file->delete();

        return response()->json(['success' => true]);
    }

    public function download(File $file)
    {
        // Cek otorisasi: Apakah pengguna boleh mengakses file ini?
        // Anda bisa membuat Gate atau Policy untuk logika ini.
        // Contoh sederhana:
        if (!auth()->check()) { // Ganti dengan logic Anda
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Pastikan file ada di storage
        if (!Storage::disk('local')->exists($file->path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('local')->download($file->path, $file->original_name);
    }

    /**
     * Menampilkan preview file (khususnya gambar) secara inline.
     */
    public function preview(File $file)
    {

        if (!Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        if (!in_array($file->mime_type, ['image/webp', 'image/jpg', 'image/jpeg', 'image/png', 'image/gif'])) {
            abort(400, 'Preview hanya tersedia untuk file gambar.');
        }

        return Storage::disk('local')->response($file->path);
    }
}