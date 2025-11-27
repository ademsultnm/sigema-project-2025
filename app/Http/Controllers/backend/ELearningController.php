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
    public function index()
    {
        // Eager load semua relasi yang dibutuhkan
        $eLearnings = ELearning::with(['guru', 'mataPelajaran', 'kelas'])->latest()->paginate(10);
        return view('backend.pages.e_learning.index', compact('eLearnings'));

        // tampilan tugas hanya untuk akun yang login sebagai guru
        // $user = auth()->user();

        // // jika role = guru -> filter berdasarkan guru_id
        // if ($user->role === 'guru') {
        //     $elearnings = Elearning::with(['guru', 'mataPelajaran', 'kelas'])
        //         ->where('guru_id', $user->guru_id)
        //         ->oldest()
        //         ->paginate(10);
        // } else {
        //     // selain guru, tampilkan semua data elearning
        //     $elearnings = Elearning::with(['guru', 'mataPelajaran', 'kelas'])
        //         ->oldest()
        //         ->paginate(10);
        // }

        // return view('backend.pages.e_learning.index', compact('elearnings'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::orderBy('nama')->get(); // Ambil data kelas untuk form
        return view('backend.pages.e_learning.create', compact('gurus', 'mataPelajarans', 'kelas'));

        // perbaikan method create
        // $user = auth()->user();
        // $gurus = ($user->role === 'guru') ? Guru::where('id', $user->guru_id)->get() : Guru::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_ids' => 'required|array', // Validasi input kelas harus array
            'kelas_ids.*' => 'exists:kelas,id', // Validasi setiap item dalam array kelas
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
        $eLearning->load('kelas'); // Muat relasi kelas
        return view('backend.pages.e_learning.show', compact('eLearning'));
    }

    public function edit(ELearning $eLearning)
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::orderBy('nama')->get();
        $eLearning->load('kelas'); // Muat kelas yang sudah terhubung
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

            // 2. Sinkronkan kelas yang dipilih (otomatis menambah/menghapus relasi)
            if (!empty($request->kelas_ids)) {
                $eLearning->kelas()->sync($request->kelas_ids);
            } else {
                $eLearning->kelas()->detach(); // Hapus semua relasi jika tidak ada kelas yang dipilih
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
            $eLearning->kelas()->detach(); // Hapus relasi di pivot table dulu
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
        // ... (fungsi download tetap sama) ...
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

