<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ELearning;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SiswaELearningController extends Controller
{
    /**
     * Menampilkan daftar materi dan tugas untuk siswa yang login.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $kelasIdSiswa = null;

        if ($siswa && $siswa->kelas->last()) {
            $kelasIdSiswa = $siswa->kelas->last()->id;
        }

        // Untuk debugging: Hapus komentar di bawah ini untuk melihat ID kelas yang ditemukan.
        // dd($kelasIdSiswa); 

        $eLearnings = ELearning::whereHas('kelas', function ($query) use ($kelasIdSiswa) {
            if ($kelasIdSiswa) {
                $query->where('kelas.id', $kelasIdSiswa);
            } else {
                $query->where('kelas.id', -1); 
            }
        })->with('guru', 'mataPelajaran')->latest()->paginate(10);
        
        return view('backend.pages.siswa_e_learning.index', compact('eLearnings'));
    }

    // ... (sisa controller tetap sama) ...
    public function show(ELearning $eLearning)
    {
        $siswaId = Auth::user()->siswa_id;
        $jawabanTerkirim = PengumpulanTugas::where('e_learning_id', $eLearning->id)
                                          ->where('siswa_id', $siswaId)
                                          ->first();

        return view('backend.pages.siswa_e_learning.show', compact('eLearning', 'jawabanTerkirim'));
    }

    public function submitTugas(Request $request, ELearning $eLearning)
    {
        $request->validate([
            'file_jawaban' => 'required|file|max:5120', // Maks 5MB
        ]);

        $siswaId = Auth::user()->siswa_id;

        if ($request->hasFile('file_jawaban')) {
            $file = $request->file('file_jawaban');
            
            PengumpulanTugas::updateOrCreate(
                [
                    'e_learning_id' => $eLearning->id,
                    'siswa_id' => $siswaId,
                ],
                [
                    'file_name' => $file->getClientOriginalName(),
                    'file_mime' => $file->getClientMimeType(),
                    'file_data' => base64_encode(file_get_contents($file->getRealPath())),
                    'waktu_pengumpulan' => now(),
                ]
            );

            return redirect()->back()->with('success', 'Jawaban berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }
}

