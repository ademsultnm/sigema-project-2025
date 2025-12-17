<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ELearning;
use App\Models\PengumpulanTugas;
use App\Models\MataPelajaran;
use App\Models\Kelas; // Tambahkan Model Kelas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class JawabanSiswaController extends Controller
{
    public function index(Request $request)
    {
        // ... (Kode index tetap sama seperti sebelumnya) ...
        $query = ELearning::with('mataPelajaran')
            ->where('tipe', 'tugas')
            ->whereHas('pengumpulanTugas')
            ->withCount('pengumpulanTugas');

        if ($request->has('mata_pelajaran_id') && $request->mata_pelajaran_id != '') {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        $tugasDenganJawaban = $query->latest()->paginate(10);
        $mataPelajarans = MataPelajaran::orderBy('nama', 'asc')->get();

        return view('backend.pages.jawaban_siswa.index', compact('tugasDenganJawaban', 'mataPelajarans'));
    }

    /**
     * UPDATE: Menambahkan Filter Kelas di sini
     */
    public function show(Request $request, ELearning $eLearning)
    {
        // 1. Siapkan Query Dasar
        $query = PengumpulanTugas::with(['siswa.kelas']) // Eager load siswa & kelasnya
            ->where('e_learning_id', $eLearning->id);

        // 2. Logika Filter Kelas (Many-to-Many)
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa.kelas', function($q) use ($request) {
                $q->where('kelas.id', $request->kelas_id);
            });
        }

        // 3. Eksekusi Query
        $pengumpulan = $query->orderBy('waktu_pengumpulan', 'desc')->get();

        // 4. Ambil Daftar Kelas untuk Dropdown
        $kelasList = Kelas::orderBy('nama', 'asc')->get();
            
        return view('backend.pages.jawaban_siswa.show', compact('eLearning', 'pengumpulan', 'kelasList'));
    }

    public function viewJawaban(PengumpulanTugas $pengumpulanTugas)
    {
        if (!$pengumpulanTugas->file_data || !$pengumpulanTugas->file_name) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileContent = base64_decode($pengumpulanTugas->file_data);

        $headers = [
            'Content-Type' => $pengumpulanTugas->file_mime ?? 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . $pengumpulanTugas->file_name . '"',
        ];

        return Response::make($fileContent, 200, $headers);
    }
}