<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    /**
     * Menampilkan daftar nilai berdasarkan peran pengguna.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // ==========================================================
        //         LOGIKA KHUSUS UNTUK TAMPILAN SISWA
        // ==========================================================
        if ($userRole === 'murid') {
            $nilais = collect(); // Default koleksi kosong
            
            // Pastikan user terhubung dengan data siswa
            if ($user->siswa_id) {
                // Ambil semua nilai milik siswa yang login, lalu kelompokkan berdasarkan mata pelajaran
                $nilais = Nilai::with('mataPelajaran', 'guru')
                    ->where('siswa_id', $user->siswa_id)
                    ->latest('tanggal_penilaian')
                    ->get()
                    ->groupBy('mataPelajaran.nama'); // Dikelompokkan berdasarkan nama mapel
            }
            return view('backend.pages.nilai.index', compact('nilais'));
        }

        // ==========================================================
        //         LOGIKA UNTUK ADMIN, GURU, DAN PERAN LAINNYA
        // ==========================================================
        $kelas = Kelas::orderBy('nama')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        
        $query = Nilai::with(['siswa', 'kelas', 'mataPelajaran', 'guru']);

        $query->when($request->kelas_id, function ($q, $kelas_id) {
            return $q->where('kelas_id', $kelas_id);
        });
        $query->when($request->mata_pelajaran_id, function ($q, $mata_pelajaran_id) {
            return $q->where('mata_pelajaran_id', $mata_pelajaran_id);
        });

        $nilais = $query->latest('tanggal_penilaian')->paginate(15);

        return view('backend.pages.nilai.index', compact('nilais', 'kelas', 'mataPelajarans'));
    }

    /**
     * Menampilkan form untuk input nilai baru.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $gurus = ($user->guru_id) ? Guru::where('id', $user->guru_id)->get() : Guru::orderBy('nama')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $semuaKelas = Kelas::orderBy('nama')->get();
        
        $siswas = collect();
        $kelasTerpilih = null;

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $kelasTerpilih = Kelas::with('siswas')->find($request->kelas_id);
            if($kelasTerpilih) {
                $siswas = $kelasTerpilih->siswas()->orderBy('nama')->get();
            }
        }
        return view('backend.pages.nilai.create', compact('gurus', 'mataPelajarans', 'semuaKelas', 'siswas', 'kelasTerpilih'));
    }

    /**
     * Menyimpan nilai massal ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            // ... (validasi store)
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'tipe_nilai' => 'required|in:Tugas,Ulangan Harian,UTS,UAS',
            'deskripsi' => 'required|string|max:255',
            'tanggal_penilaian' => 'required|date',
            'tahun_ajaran' => 'required|string|max:9',
            'semester' => 'required|in:Ganjil,Genap',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            DB::beginTransaction();
            foreach ($request->nilai as $siswa_id => $nilai) {
                if (!is_null($nilai) && $nilai !== '') {
                    Nilai::updateOrCreate(
                        [
                            'siswa_id' => $siswa_id,
                            'deskripsi' => $request->deskripsi, // Asumsi deskripsi unik untuk satu kali input
                            'tanggal_penilaian' => $request->tanggal_penilaian,
                            'mata_pelajaran_id' => $request->mata_pelajaran_id,
                        ],
                        [
                            'kelas_id' => $request->kelas_id,
                            'guru_id' => $request->guru_id,
                            'tipe_nilai' => $request->tipe_nilai,
                            'nilai' => $nilai,
                            'tahun_ajaran' => $request->tahun_ajaran,
                            'semester' => $request->semester,
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('nilai.index')->with('success', 'Nilai berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function edit(Nilai $nilai)
    {
        $gurus = Guru::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        
        $siswas = Siswa::whereHas('kelas', function ($query) use ($nilai) {
            $query->where('kelas.id', $nilai->kelas_id);
        })->orderBy('nama')->get();

        return view('backend.pages.nilai.edit', compact('nilai', 'gurus', 'kelas', 'mataPelajarans', 'siswas'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            // ... (validasi update)
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'tipe_nilai' => 'required|in:Tugas,Ulangan Harian,UTS,UAS',
            'deskripsi' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'tanggal_penilaian' => 'required|date',
            'tahun_ajaran' => 'required|string|max:9',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $nilai->update($request->all());

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}

