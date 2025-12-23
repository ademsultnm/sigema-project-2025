<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiGuruController extends Controller
{
    public function index()
    {
        // Menampilkan data terbaru
        $absensiGurus = AbsensiGuru::with('guru')->latest()->paginate(20);
        return view('backend.pages.absensi-guru.index', compact('absensiGurus'));
    }

    public function create()
    {
        // Ambil semua data guru diurutkan nama
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('backend.pages.absensi-guru.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenjang' => 'required|in:SMP,SMA',
            'kehadiran' => 'required|array', // Pastikan kehadiran berbentuk array
            'kehadiran.*' => 'required|in:hadir,tidak_hadir,izin,sakit,alpha', // Validasi isi array
        ]);

        $tanggal = $request->tanggal;
        $jenjang = $request->jenjang;
        $dataKehadiran = $request->kehadiran; // Array [guru_id => status]

        try {
            DB::beginTransaction();

            foreach ($dataKehadiran as $guruId => $status) {
                // Gunakan updateOrCreate agar jika data tanggal & guru tersebut sudah ada, 
                // datanya di-update (tidak duplikat).
                AbsensiGuru::updateOrCreate(
                    [
                        'guru_id' => $guruId,
                        'tanggal' => $tanggal,
                    ],
                    [
                        'kehadiran' => $status,
                        'jenjang' => $jenjang, // Atau ambil dari data guru jika di tabel guru ada kolom jenjang
                    ]
                );
            }

            DB::commit();
            return redirect()->route('absensi-guru.index')
                ->with('success', 'Absensi masal berhasil disimpan untuk tanggal ' . $tanggal);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method show, edit, update, destroy biarkan tetap sama atau sesuaikan jika perlu edit satu per satu
    public function show(AbsensiGuru $absensiGuru)
    {
        return view('backend.pages.absensi-guru.show', compact('absensiGuru'));
    }

    public function edit(AbsensiGuru $absensiGuru)
    {
        $gurus = Guru::all();
        return view('backend.pages.absensi-guru.edit', compact('absensiGuru', 'gurus'));
    }

    public function update(Request $request, AbsensiGuru $absensiGuru)
    {
        $request->validate([
            'guru_id' => 'required',
            'tanggal' => 'required|date',
            'kehadiran' => 'required',
            'jenjang' => 'required',
        ]);
        $absensiGuru->update($request->all());
        return redirect()->route('absensi-guru.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(AbsensiGuru $absensiGuru)
    {
        $absensiGuru->delete();
        return redirect()->route('absensi-guru.index')->with('success', 'Data berhasil dihapus');
    }
}