<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Raport;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RaportController extends Controller
{
    // =========================================================================
    // FITUR UTAMA: INDEX & FILTER
    // =========================================================================
    public function index(Request $request)
    {
        $query = Raport::with(['siswa.kelas', 'mataPelajaran']);

        // 1. Filter Nama Siswa
        if ($request->has('nama_siswa') && $request->nama_siswa != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama_siswa . '%');
            });
        }

        // 2. Filter Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa.kelas', function ($q) use ($request) {
                $q->where('kelas.id', $request->kelas_id);
            });
        }

        // 3. Filter Mata Pelajaran
        if ($request->has('mata_pelajaran_id') && $request->mata_pelajaran_id != '') {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        // 4. Filter Semester & Tahun Ajaran
        if ($request->has('semester') && $request->semester != '') {
            $query->where('semester', $request->semester);
        }
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran != '') {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $raports = $query->latest()->paginate(10);
        
        // Data untuk Dropdown Filter
        $kelasList = Kelas::orderBy('nama', 'asc')->get();
        $mataPelajaranList = MataPelajaran::orderBy('nama', 'asc')->get();

        return view('backend.pages.raports.index', compact('raports', 'kelasList', 'mataPelajaranList'));
    }

    // =========================================================================
    // FITUR DOWNLOAD PDF
    // =========================================================================
    public function exportPdf(Request $request)
    {
        // Copy logic filter dari index
        $query = Raport::with(['siswa.kelas', 'mataPelajaran']);

        if ($request->has('nama_siswa') && $request->nama_siswa != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama_siswa . '%');
            });
        }
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa.kelas', function ($q) use ($request) {
                $q->where('kelas.id', $request->kelas_id);
            });
        }
        if ($request->has('mata_pelajaran_id') && $request->mata_pelajaran_id != '') {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
        if ($request->has('semester') && $request->semester != '') {
            $query->where('semester', $request->semester);
        }
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran != '') {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Ambil semua data tanpa pagination
        $raports = $query->latest()->get();

        $pdf = Pdf::loadView('backend.pages.raports.pdf', compact('raports'));
        
        return $pdf->stream('Laporan-Raport-'.date('Y-m-d').'.pdf');
    }

    // =========================================================================
    // CRUD: CREATE (Menampilkan Form Tambah)
    // =========================================================================
    public function create()
    {
        // PERBAIKAN: Mendefinisikan variabel $siswas dan $mataPelajarans
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama', 'asc')->get();
        
        return view('backend.pages.raports.create', compact('siswas', 'mataPelajarans'));
    }

    // =========================================================================
    // CRUD: STORE (Menyimpan Data Baru)
    // =========================================================================
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'rata_rata_nilai' => 'required|numeric',
            'keterangan' => 'required',
            'jenjang' => 'required|in:SMP,SMA',
        ]);

        Raport::create($request->all());

        return redirect()->route('raports.index')->with('success', 'Raport berhasil ditambahkan.');
    }

    // =========================================================================
    // CRUD: SHOW (Detail)
    // =========================================================================
    public function show(Raport $raport)
    {
        return view('backend.pages.raports.show', compact('raport'));
    }

    // =========================================================================
    // CRUD: EDIT (Menampilkan Form Edit)
    // =========================================================================
    public function edit(Raport $raport)
    {
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama', 'asc')->get();

        return view('backend.pages.raports.edit', compact('raport', 'siswas', 'mataPelajarans'));
    }

    // =========================================================================
    // CRUD: UPDATE (Menyimpan Perubahan)
    // =========================================================================
    public function update(Request $request, Raport $raport)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'rata_rata_nilai' => 'required|numeric',
            'keterangan' => 'required',
            'jenjang' => 'required|in:SMP,SMA',
        ]);

        $raport->update($request->all());

        return redirect()->route('raports.index')->with('success', 'Raport berhasil diperbarui.');
    }

    // =========================================================================
    // CRUD: DESTROY (Hapus Data)
    // =========================================================================
    public function destroy(Raport $raport)
    {
        $raport->delete();
        return redirect()->route('raports.index')->with('success', 'Raport berhasil dihapus.');
    }
}