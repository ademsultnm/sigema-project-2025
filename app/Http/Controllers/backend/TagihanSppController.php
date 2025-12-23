<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TagihanSpp;
use App\Models\Siswa;
use App\Models\Kelas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanSppController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // ==========================================================
        //         LOGIKA KHUSUS UNTUK TAMPILAN SISWA
        // ==========================================================
        if ($userRole === 'murid') {
            $tagihanSpps = collect();
            if ($user->siswa_id) {
                $tagihanSpps = TagihanSpp::where('siswa_id', $user->siswa_id)
                                        ->latest('jatuh_tempo')
                                        ->paginate(10);
            }
            $apiKey = config('settings.paydisini_api_key', '');
            return view('backend.pages.tagihan_spp.index', compact('tagihanSpps', 'apiKey'));
        }

        // ==========================================================
        //         LOGIKA UNTUK ADMIN & STAF KEUANGAN
        // ==========================================================
        
        // 1. Load siswa beserta history kelasnya (pivot table)
        $query = TagihanSpp::with(['siswa.kelas']); 

        // 2. Filter Berdasarkan Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa.kelas', function($q) use ($request) {
                $q->where('kelas.id', $request->kelas_id);
            });
        }

        // 3. Eksekusi Query
        $tagihanSpps = $query->latest()->paginate(10);

        // 4. Ambil Daftar Kelas untuk Dropdown (Urutkan berdasarkan nama)
        $kelasList = Kelas::orderBy('nama', 'asc')->get(); 

        return view('backend.pages.tagihan_spp.index', compact('tagihanSpps', 'kelasList'));
    }

    // ... (Method create, store, edit, update, destroy Biarkan Tetap Sama) ...
    public function create()
    {
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        return view('backend.pages.tagihan_spp.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'jatuh_tempo' => 'required|date',
            'status' => 'required|in:Belum Lunas,Lunas',
            'tahun_ajaran' => 'required|string|max:9',
        ]);
        TagihanSpp::create($request->all());
        return redirect()->route('tagihan-spp.index')->with('success', 'Tagihan SPP berhasil ditambahkan.');
    }

    public function show(TagihanSpp $tagihanSpp)
    {
        $tagihanSpp->load('siswa');
        return view('backend.pages.tagihan_spp.show', compact('tagihanSpp'));
    }

    public function edit(TagihanSpp $tagihanSpp)
    {
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        return view('backend.pages.tagihan_spp.edit', compact('tagihanSpp', 'siswas'));
    }

    public function update(Request $request, TagihanSpp $tagihanSpp)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'jatuh_tempo' => 'required|date',
            'status' => 'required|in:Belum Lunas,Lunas',
            'tahun_ajaran' => 'required|string|max:9',
        ]);
        $tagihanSpp->update($request->all());
        return redirect()->route('tagihan-spp.index')->with('success', 'Tagihan SPP berhasil diperbarui.');
    }

    public function destroy(TagihanSpp $tagihanSpp)
    {
        $tagihanSpp->delete();
        return redirect()->route('tagihan-spp.index')->with('success', 'Tagihan SPP berhasil dihapus.');
    }
}