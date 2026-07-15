<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Raport; // pastikan model raport diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data statistik dari database.
     */
    public function index()
    {
        // Mengambil data pengguna yang sedang login
        $user = Auth::user();
        
        // ===========================================================
        //  LOGIKA UNTUK DASHBOARD SISWA
        // ===========================================================

        if ($user->role === 'siswa') {
            
            // Ambil data dari relasi user
            $siswa = $user->siswa;

            if (!$siswa) {
                return view('backend.dashboard', ['user_role' => 'siswa', 'error' => 'Data siswa tidak ditemukan.']);
            }

            // ambil nilai rata-rata raport per mata pelajaran (group by mapel)
            // asumsi: tabel raport punya kolom 'mata_pelajaran_id' dan 'rata_rata_nilai'
            $nilaiPerMapel = Raport::with('mataPelajaran')->where('siswa_id', $siswa->id)->get()->groupBy('mata_pelajaran_id')->map(function ($items) {
                return [
                    'mapel_nama' => $items->first()->mataPelajaran->nama ?? 'Mapel Dihapus',
                    'mapel_id' => $items->first()->mata_pelajaran_id,
                    'rata_rata_nilai' => round($items->avg('rata_rata_nilai'), 1),
                    'jumlah_data' => $items->count()
                ];
            });
            return view('backend.dashboard_siswa', [
                'user_name' => $user->name,
                'user_role' => $user->role,
                'siswa' => $siswa,
                'nilaiPerMapel' => $nilaiPerMapel,
            ]);
        }


        // ===========================================================
        //  LOGIKA UNTUK DASHBOARD ADMIN/GURU
        // ===========================================================

        // Menghitung data statistik utama
        $jumlahSiswa = Siswa::count();
        $jumlahGuru = Guru::count();
        $jumlahKelas = Kelas::count();
        $jumlahMapel = MataPelajaran::count();

        // Menghitung jumlah siswa per jenjang untuk grafik donat
        $siswaSMP = Siswa::where('jenjang', 'SMP')->count();
        $siswaSMA = Siswa::where('jenjang', 'SMA')->count();

        // Mengambil 5 siswa dan guru terbaru untuk ditampilkan di tabel
        $siswaTerbaru = Siswa::latest()->take(5)->get();
        $guruTerbaru = Guru::latest()->take(5)->get();

        // Grafik Pertumbuhan Siswa
        $siswaPerBulan = Siswa::select(
            DB::raw('COUNT(id) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
        )
        ->where('created_at', '>', Carbon::now()->subMonths(12))->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $chartLabels = [];
        $chartData = [];

        // Inisialisasi data 12 bulan ke belakang dengan nilai 0
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $chartLabels[] = $bulan->format('M Y');
            $chartData[$bulan->format('Y-m')] = 0;
        }
        // Isi dengan data dari database
        foreach ($siswaPerBulan as $data) {
            $chartData[$data->bulan] = $data->total;
        }
        $finalChartData = array_values($chartData);
        // --- AKHIR DATA GRAFIK ---

        // Mengirim semua data ke view 'dashboard'
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

    // menampilkan detail nilai (layer 2 - excel look)
    public function detailNilai($mapel_id) {
        $user = Auth::user();

        // hanya siswa yang mengakses
        if ($user->role !== 'siswa') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = $user->siswa;

        // ambil mata pelajaran
        $mapel = MataPelajaran::findOrFail($mapel_id);

        // ambil detail nilai (raport) siswa ini untuk mapel tersebut
        $detailNilai = Raport::where('siswa_id', $siswa->id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->with(['siswa_kelas'])
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // hitung rata-rata keseluruhan
        $rataRataMapel = round($detailNilai->avg('rata_rata_nilai'), 2);

        // tampilkan view
        return view('backend.pages.nilai.detail', compact('mapel', 'detailNilai', 'rataRataMapel', 'siswa'));
    }
}

