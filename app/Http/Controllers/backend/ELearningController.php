<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ELearning;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Kelas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ELearningController extends Controller
{
    // UPDATE: Tambahkan Request $request untuk menangkap input filter
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar dengan Eager Loading
        $query = ELearning::with(['guru', 'mataPelajaran', 'kelas']);

        // 2. Logika Filter Berdasarkan Guru
        if ($request->has('guru_id') && $request->guru_id != '') {
            $query->where('guru_id', $request->guru_id);
        }

        // 3. Eksekusi Query
        $eLearnings = $query->latest()->paginate(10);

        // 4. Ambil Data Guru untuk Dropdown Filter (Urut Abjad)
        $gurus = Guru::orderBy('nama', 'asc')->get();

        return view('backend.pages.e_learning.index', compact('eLearnings', 'gurus'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::orderBy('nama')->get(); 
        return view('backend.pages.e_learning.create', compact('gurus', 'mataPelajarans', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_ids' => 'required|array', 
            'kelas_ids.*' => 'exists:kelas,id', 
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenjang' => 'required|in:SMP,SMA',
            'tipe' => 'required|in:materi,tugas',
            'batas_waktu' => 'nullable|date',
            'materi_file' => 'nullable|file|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['materi_file', 'kelas_ids']);

            if ($request->hasFile('materi_file')) {
                $file = $request->file('materi_file');
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_mime'] = $file->getClientMimeType();
                $data['file_data'] = base64_encode(file_get_contents($file->getRealPath()));
            }

            // 1. Buat data E-Learning
            $eLearning = ELearning::create($data);

            // 2. Lampirkan kelas yang dipilih ke data E-Learning
            if (!empty($request->kelas_ids)) {
                $eLearning->kelas()->attach($request->kelas_ids);
            }

            DB::commit();
            return redirect()->route('e_learning.index')->with('success', 'E-Learning berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(ELearning $eLearning)
    {
        $eLearning->load('kelas'); 
        return view('backend.pages.e_learning.show', compact('eLearning'));
    }

    public function edit(ELearning $eLearning)
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::orderBy('nama')->get();
        $eLearning->load('kelas'); 
        return view('backend.pages.e_learning.edit', compact('eLearning', 'gurus', 'mataPelajarans', 'kelas'));
    }

    public function update(Request $request, ELearning $eLearning)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_ids' => 'required|array',
            'kelas_ids.*' => 'exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenjang' => 'required|in:SMP,SMA',
            'tipe' => 'required|in:materi,tugas',
            'batas_waktu' => 'nullable|date',
            'materi_file' => 'nullable|file|max:5120',
        ]);

        try {
            DB::beginTransaction();
            
            $data = $request->except(['materi_file', 'kelas_ids']);

            if ($request->hasFile('materi_file')) {
                $file = $request->file('materi_file');
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_mime'] = $file->getClientMimeType();
                $data['file_data'] = base64_encode(file_get_contents($file->getRealPath()));
            }

            // 1. Update data E-Learning
            $eLearning->update($data);

            // 2. Sinkronkan kelas
            if (!empty($request->kelas_ids)) {
                $eLearning->kelas()->sync($request->kelas_ids);
            } else {
                $eLearning->kelas()->detach(); 
            }

            DB::commit();
            return redirect()->route('e_learning.index')->with('success', 'E-Learning berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(ELearning $eLearning)
    {
        try {
            DB::beginTransaction();
            $eLearning->kelas()->detach(); 
            $eLearning->delete();
            DB::commit();
            return redirect()->route('e_learning.index')->with('success', 'E-Learning berhasil dihapus.');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }

    public function download(ELearning $eLearning)
    {
        if (!$eLearning->file_data || !$eLearning->file_name) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileContent = base64_decode($eLearning->file_data);

        $headers = [
            'Content-Type' => $eLearning->file_mime ?? 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $eLearning->file_name . '"',
        ];

        return Response::make($fileContent, 200, $headers);
    }
}