<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ELearning;
use App\Models\PengumpulanTugas;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class JawabanSiswaController extends Controller
{
    /**
     * Menampilkan daftar tugas yang sudah memiliki jawaban dari siswa.
     */
    public function index(Request $request)
    {
        // $tugasDenganJawaban = ELearning::where('tipe', 'tugas')
        $query = Elearning::with('mataPelajaran')
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
     * UPDATE: Menambahkan Filter kelas disini
     */
    public function show(Request $request, ELearning $eLearning)
    {
        // $pengumpulan = PengumpulanTugas::with('siswa')
        //     ->where('e_learning_id', $eLearning->id)
        //     ->orderBy('waktu_pengumpulan', 'desc')
        //     ->get();

        // 1. siapkan Query dasar
        $query = PengumpulanTugas::with(['siswa.kelas']) //eager load relasi siswa dan kelas
            ->where('e_learning_id', $eLearning->id);
            

        // 2. tambahkan filter kelas jika ada many to many
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa.kelas', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // 3. eksekusi query
        $pengumpulan = $query->orderBy('waktu_pengumpulan', 'desc')->get();

        // 4. ambil kelas list
        $kelasList = Kelas::orderBy('nama', 'asc')->get();

        return view('backend.pages.jawaban_siswa.show', compact('eLearning', 'pengumpulan', 'kelasList'));
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
