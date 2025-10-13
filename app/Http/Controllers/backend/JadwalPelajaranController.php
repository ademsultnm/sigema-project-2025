<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $semuaKelas = Kelas::orderBy('nama')->get();
        $query = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru']);

        $query->when($request->kelas_id, function ($q, $kelas_id) {
            return $q->where('kelas_id', $kelas_id);
        });

        $jadwals = $query->orderBy('jam_mulai', 'asc')->get()->groupBy('hari');
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('backend.pages.jadwal_pelajaran.index', compact('jadwals', 'semuaKelas', 'days'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();
        return view('backend.pages.jadwal_pelajaran.create', compact('kelas', 'mataPelajarans', 'gurus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tahun_ajaran' => 'required|string|max:9',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $this->checkConflict($validatedData);

        JadwalPelajaran::create($validatedData);
        return redirect()->route('jadwal-pelajaran.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $kelas = Kelas::orderBy('nama')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();
        return view('backend.pages.jadwal_pelajaran.edit', compact('jadwalPelajaran', 'kelas', 'mataPelajarans', 'gurus'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $validatedData = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tahun_ajaran' => 'required|string|max:9',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $this->checkConflict($validatedData, $jadwalPelajaran->id);

        $jadwalPelajaran->update($validatedData);
        return redirect()->route('jadwal-pelajaran.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->delete();
        return redirect()->route('jadwal-pelajaran.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Helper function untuk memeriksa konflik jadwal.
     */
    private function checkConflict($data, $ignoreId = null)
    {
        $query = JadwalPelajaran::where('hari', $data['hari'])
            ->where('tahun_ajaran', $data['tahun_ajaran'])
            ->where('semester', $data['semester'])
            ->where(function($q) use ($data) {
                $q->where(function($sub) use ($data) {
                    $sub->where('jam_mulai', '<', $data['jam_selesai'])
                        ->where('jam_selesai', '>', $data['jam_mulai']);
                });
            });

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        // Cek konflik guru
        $conflictGuru = (clone $query)->where('guru_id', $data['guru_id'])->exists();
        if ($conflictGuru) {
            throw ValidationException::withMessages(['guru_id' => 'Konflik jadwal: Guru sudah memiliki jadwal lain pada waktu ini.']);
        }

        // Cek konflik kelas
        $conflictKelas = (clone $query)->where('kelas_id', $data['kelas_id'])->exists();
        if ($conflictKelas) {
            throw ValidationException::withMessages(['kelas_id' => 'Konflik jadwal: Kelas sudah memiliki jadwal lain pada waktu ini.']);
        }
    }
}
