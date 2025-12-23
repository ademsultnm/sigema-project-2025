<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiSiswaController extends Controller
{
    /**
     * Menampilkan data absensi berdasarkan peran pengguna.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // ==========================================================
        //         LOGIKA KHUSUS UNTUK TAMPILAN SISWA
        // ==========================================================
        if ($userRole === 'murid') {
            $absensiSiswa = collect(); // Default koleksi kosong
            if ($user->siswa_id) {
                $absensiSiswa = AbsensiSiswa::where('siswa_id', $user->siswa_id)
                    ->latest('tanggal')
                    ->paginate(15);
            }
            return view('backend.pages.absensi_siswa.index', compact('absensiSiswa'));
        }

        // ==========================================================
        //         LOGIKA UNTUK ADMIN, GURU, DAN PERAN LAINNYA
        // ==========================================================
        $semuaKelas = Kelas::orderBy('nama')->get();
        
        $query = AbsensiSiswa::with('kelas')
                    ->select('kelas_id', 'tanggal', 
                            DB::raw('count(*) as total_siswa'),
                            DB::raw("sum(case when kehadiran = 'hadir' then 1 else 0 end) as total_hadir"),
                            DB::raw("sum(case when kehadiran = 'izin' then 1 else 0 end) as total_izin"),
                            DB::raw("sum(case when kehadiran = 'sakit' then 1 else 0 end) as total_sakit"),
                            DB::raw("sum(case when kehadiran = 'tidak_hadir' then 1 else 0 end) as total_alpha"))
                    ->whereNotNull('kelas_id')
                    ->groupBy('kelas_id', 'tanggal');

        $query->when($request->kelas_id, fn($q, $v) => $q->where('kelas_id', $v));
        $query->when($request->tanggal, fn($q, $v) => $q->whereDate('tanggal', $v));

        $rekapAbsensi = $query->latest('tanggal')->paginate(10);

        return view('backend.pages.absensi_siswa.index', compact('rekapAbsensi', 'semuaKelas'));
    }

    // ... (sisa method controller tetap sama) ...
    public function create(Request $request)
    {
        $semuaKelas = Kelas::orderBy('nama')->get();
        $siswas = collect();
        $kelasTerpilih = null;
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $kelasTerpilih = Kelas::with('siswas')->find($request->kelas_id);
            if ($kelasTerpilih) {
                $siswas = $kelasTerpilih->siswas()->orderBy('nama')->get();
            }
        }

        return view('backend.pages.absensi_siswa.create', compact('semuaKelas', 'siswas', 'kelasTerpilih', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'kehadiran' => 'required|array',
        ]);

        try {
            DB::beginTransaction();
            foreach ($request->kehadiran as $siswa_id => $status) {
                if (!empty($status)) {
                    AbsensiSiswa::updateOrCreate(
                        ['siswa_id' => $siswa_id, 'tanggal'  => $request->tanggal],
                        [
                            'kehadiran' => $status,
                            'kelas_id' => $request->kelas_id,
                            'jenjang' => Siswa::find($siswa_id)->jenjang ?? 'SMP',
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('absensi_siswa.index')->with('success', 'Absensi siswa berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function show_class(Kelas $kelas, $tanggal)
    {
        $absensiSiswa = AbsensiSiswa::with('siswa')
            ->where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $tanggal)
            ->get();
        return view('backend.pages.absensi_siswa.show_class', compact('absensiSiswa', 'kelas', 'tanggal'));
    }
    
    public function edit($id)
    {
        $absensi_siswa = AbsensiSiswa::findOrFail($id);
        return view('backend.pages.absensi_siswa.edit', compact('absensi_siswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kehadiran' => 'required|in:hadir,tidak_hadir,izin,sakit',
        ]);
        $absensi_siswa = AbsensiSiswa::findOrFail($id);
        $absensi_siswa->update($request->all());
        return redirect()->route('absensi_siswa.show_class', ['kelas' => $absensi_siswa->kelas_id, 'tanggal' => $absensi_siswa->tanggal])
                        ->with('success', 'Absensi siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $absensiSiswa = AbsensiSiswa::findOrFail($id);
        $absensiSiswa->delete();
        return redirect()->back()->with('success', 'Data absensi berhasil dihapus.');
    }
}

