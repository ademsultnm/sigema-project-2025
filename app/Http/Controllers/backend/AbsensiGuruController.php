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
        // $absensiGurus = AbsensiGuru::with()->paginate(10);
        $absensiGurus = AbsensiGuru::with('guru')->latest()->paginate(20);
        // menampilkan data terbaru
        return view('backend.pages.absensi-guru.index', compact('absensiGurus'));
    }

    public function create()
    {
        // $gurus = Guru::all()
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('backend.pages.absensi-guru.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'guru_id' => 'required',
            'tanggal' => 'required|date',
            // 'kehadiran' => 'required|in:hadir,tidak_hadir,izin',
            'jenjang' => 'required|in:SMP,SMA',
            'kehadiran'=> 'required|array', //pastikan kehadiran adalah array
            'kehadiran.*' => 'required|in:hadir,tidak_hadir,izin,sakit,alpha' //validasi setiap elemen dalam array
        ]);

        // AbsensiGuru::create($request->all());

        $tanggal = $request->tanggal;
        $jenjang = $request->jenjang;
        $datakehadiran = $request->kehadiran; //array dari kehadiran

        try {
            DB::beginTransaction();

            foreach ($datakehadiran as $guru_id => $status) {
                AbsensiGuru::updateOrCreate([
                    'guru_id' => $guru_id,
                    'tanggal' => $tanggal,
                    ], [
                    'jenjang' => $jenjang,
                    'kehadiran' => $status,
                ]);
            }

            DB::commit();
            return redirect()->route('absensi-guru.index')
                ->with('success', 'Absensi guru berhasil ditambahkan.' . $tanggal);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage())
                ->withInput();
        }
    }


    //method show, edit, update, destroy untuk absensi guru
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

        return redirect()->route('absensi-guru.index')->with('success', 'Data absensi guru berhasil diperbarui.');
    }
    public function destroy(AbsensiGuru $absensiGuru)
    {
        $absensiGuru->delete();

        return redirect()->route('absensi-guru.index')->with('success', 'Absensi guru berhasil dihapus.');
    }
}
