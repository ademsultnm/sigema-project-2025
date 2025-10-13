<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\User;
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

        // --- DATA UNTUK GRAFIK PERTUMBUHAN SISWA (12 BULAN TERAKHIR) ---
        $siswaPerBulan = Siswa::select(
            DB::raw('COUNT(id) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
        )
        ->where('created_at', '>', Carbon::now()->subMonths(12))
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->get();

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
}

