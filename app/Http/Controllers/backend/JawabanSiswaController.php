<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ELearning;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class JawabanSiswaController extends Controller
{
    /**
     * Menampilkan daftar tugas yang sudah memiliki jawaban dari siswa.
     */
    public function index()
    {
        $tugasDenganJawaban = ELearning::where('tipe', 'tugas')
            ->whereHas('pengumpulanTugas')
            ->withCount('pengumpulanTugas')
            ->latest()
            ->paginate(10);

        return view('backend.pages.jawaban_siswa.index', compact('tugasDenganJawaban'));
    }

    /**
     * Menampilkan daftar siswa yang sudah mengumpulkan jawaban untuk tugas tertentu.
     */
    public function show(ELearning $eLearning)
    {
        $pengumpulan = PengumpulanTugas::with('siswa')
            ->where('e_learning_id', $eLearning->id)
            ->orderBy('waktu_pengumpulan', 'desc')
            ->get();
            
        return view('backend.pages.jawaban_siswa.show', compact('eLearning', 'pengumpulan'));
    }

    /**
     * Menampilkan file jawaban yang diunggah siswa di browser.
     */
    public function viewJawaban(PengumpulanTugas $pengumpulanTugas)
    {
        if (!$pengumpulanTugas->file_data || !$pengumpulanTugas->file_name) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileContent = base64_decode($pengumpulanTugas->file_data);

        // PERBAIKAN: Mengubah 'attachment' menjadi 'inline'
        $headers = [
            'Content-Type' => $pengumpulanTugas->file_mime ?? 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . $pengumpulanTugas->file_name . '"',
        ];

        return Response::make($fileContent, 200, $headers);
    }
}
