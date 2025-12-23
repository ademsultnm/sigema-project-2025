<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Raport; // Pastikan Model Raport di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // =================================================================
        // LOGIKA DASHBOARD UNTUK SISWA
        // =================================================================
        if ($user->role === 'siswa') {
            // Ambil data siswa dari relasi user
            $siswa = $user->siswa; 

            if (!$siswa) {
                return view('backend.dashboard', ['user_role' => 'siswa', 'error' => 'Data siswa tidak ditemukan.']);
            }

            // Ambil Nilai Rata-rata per Mata Pelajaran (Group By Mapel)
            // Asumsi: Tabel raport punya kolom 'mata_pelajaran_id' dan 'rata_rata_nilai'
            $nilaiPerMapel = Raport::with('mataPelajaran')
                ->where('siswa_id', $siswa->id)
                ->get()
                ->groupBy('mata_pelajaran_id')
                ->map(function ($items) {
                    return [
                        'mapel_nama' => $items->first()->mataPelajaran->nama ?? 'Mapel Dihapus',
                        'mapel_id'   => $items->first()->mata_pelajaran_id,
                        // Hitung rata-rata dari semua semester untuk mapel ini
                        'rata_rata_total' => round($items->avg('rata_rata_nilai'), 1), 
                        'jumlah_data' => $items->count()
                    ];
                });

            return view('backend.dashboard', [
                'user_name' => $user->name,
                'user_role' => $user->role,
                'nilaiPerMapel' => $nilaiPerMapel
            ]);
        }

        // =================================================================
        // LOGIKA DASHBOARD UNTUK ADMIN / GURU / STAFF (KODE LAMA)
        // =================================================================
        $jumlahSiswa = Siswa::count();
        $jumlahGuru = Guru::count();
        $jumlahKelas = Kelas::count();
        $jumlahMapel = MataPelajaran::count();
        $siswaSMP = Siswa::where('jenjang', 'SMP')->count();
        $siswaSMA = Siswa::where('jenjang', 'SMA')->count();
        $siswaTerbaru = Siswa::latest()->take(5)->get();
        $guruTerbaru = Guru::latest()->take(5)->get();

        // Grafik Pertumbuhan Siswa
        $siswaPerBulan = Siswa::select(
            DB::raw('COUNT(id) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
        )->where('created_at', '>', Carbon::now()->subMonths(12))
        ->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $chartLabels[] = $bulan->format('M Y');
            $chartData[$bulan->format('Y-m')] = 0;
        }
        foreach ($siswaPerBulan as $data) {
            $chartData[$data->bulan] = $data->total;
        }
        $finalChartData = array_values($chartData);

        return view('backend.dashboard', [
            'user_name' => $user->name,
            'user_role' => $user->role,
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahGuru' => $jumlahGuru,
            'jumlahKelas' => $jumlahKelas,
            'jumlahMapel' => $jumlahMapel,
            'siswaSMP' => $siswaSMP,
            'siswaSMA' => $siswaSMA,
            'siswaTerbaru' => $siswaTerbaru,
            'guruTerbaru' => $guruTerbaru,
            'chartLabels' => json_encode($chartLabels),
            'chartData' => json_encode($finalChartData),
        ]);
    }

    /**
     * Menampilkan Detail Nilai (Layer 2 - Excel Look)
     */
    public function detailNilai($mapel_id)
    {
        $user = Auth::user();
        
        // Pastikan yang akses adalah siswa
        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        $siswa = $user->siswa;
        
        // Ambil mata pelajaran
        $mapel = MataPelajaran::findOrFail($mapel_id);

        // Ambil detail nilai (raport) siswa ini untuk mapel tersebut
        $detailNilai = Raport::where('siswa_id', $siswa->id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->with(['siswa.kelas']) // Load relasi kelas untuk ditampilkan di header
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // Hitung rata-rata nilai mapel ini secara spesifik
        $rataRataMapel = round($detailNilai->avg('rata_rata_nilai'), 2);

        return view('backend.pages.nilai.detail', compact('mapel', 'detailNilai', 'rataRataMapel', 'siswa'));
    }
}