<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TagihanSpp;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanSppController extends Controller
{
    /**
     * Menampilkan daftar tagihan SPP berdasarkan peran pengguna.
     */
    public function index()
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
            // Ambil API key dari pengaturan (jika sudah ada)
            // Untuk sementara kita gunakan placeholder
            $apiKey = config('settings.paydisini_api_key', '');
            return view('backend.pages.tagihan_spp.index', compact('tagihanSpps', 'apiKey'));
        }

        // ==========================================================
        //         LOGIKA UNTUK ADMIN & STAF KEUANGAN
        // ==========================================================
        $tagihanSpps = TagihanSpp::with('siswa')->latest()->paginate(10);
        return view('backend.pages.tagihan_spp.index', compact('tagihanSpps'));
    }

    // ... (method create, store, edit, update, destroy tetap sama) ...
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

