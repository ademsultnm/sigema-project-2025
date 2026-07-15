<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
// use App\Models\PembayaranSpp;
use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganExport;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // 1. validasi filter tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // list($pembayarans, $startDate, $endDate) = $this->getLaporanData($request);

        // 2. tentukan rentang tanggal (default: awal bulan s/d akhir bulan ini)
        // $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        // $endInput = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();


        // 3. QUERY PEMASUKAN: ambil tagihan yang statusnya 'lunas'
        // kita gunakan 'updated_at' sebagai asumsi waktu pelunasan
        $laporanPemasukan = TagihanSpp::with('siswa')->where('status', 'lunas')->whereBetween('updated_at', [$startDate, $endDate])->latest('updated_at')->get();

        // 4. HITUNG TOTAL PEMASUKAN DAN TUNGGAKAN
        $totalPemasukan = $laporanPemasukan->sum('jumlah_tagihan');

        // 5. hitung total tunggakan ALL TIME
        // menghitung potensi uang yang belum masuk
        $totalTunggakan = TagihanSpp::where('status', 'Belum Lunas')->sum('jumlah_tagihan');

        // variabel untuk tampilan tanggal di input form (YY-MM-DD)
        $endDateDisplay = Carbon::parse($endDate)->toDateString();

        return view('backend.pages.laporan_keuangan.index', compact(
            'laporanPemasukan',
            'totalPemasukan',
            'totalTunggakan',
            'startDate',
            'endDateDisplay'
        ));
    }

    // export laporan ke PDF
    public function exportPdf(Request $request)
    {
        // list($pembayarans, $startDate, $endDate) = $this->getLaporanData($request);
        // $totalPemasukan = $pembayarans->sum('jumlah_bayar');

        // logika tanggal sama dengan index
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endInput = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $endDate = Carbon::parse($endInput)->endOfDay();

        //Query data
        $laporanPemasukan = TagihanSpp::with('siswa')->where('status', 'lunas')->whereBetween('updated_at', [$startDate, $endDate])->latest('updated_at')->get();

        $totalPemasukan = $laporanPemasukan->sum('jumlah_tagihan');
        $endDateDisplay = Carbon::parse($endInput)->toDateString();

        // load view PDF
        // pastikan file view 'backend.pages.laporan_keuangan.pdf' sudah dibuat
        $pdf = PDF::loadView('backend.pages.laporan_keuangan.pdf', compact('laporanPemasukan', 'startDate', 'endDateDisplay', 'totalPemasukan'));

        return $pdf->stream('laporan-keuangan-' . $startDate . '-sd-' . $endDateDisplay . '.pdf');
    }

    // export laporan ke excel (opsional)
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // pastikan class LaporanKeuanganExport sudah dibuat dan disesuaikan querynya ke tagihanSpp
        return Excel::download(new LaporanKeuanganExport($startDate, $endDate), 'laporan-keuangan-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    // private function getLaporanData(Request $request)
    // {
    //     $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
    //     $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

    //     $pembayarans = PembayaranSpp::with('siswa', 'verifikator', 'tagihan')
    //         ->where('status_verifikasi', 'Terverifikasi')
    //         ->whereBetween('tanggal_bayar', [$startDate, Carbon::parse($endDate)->endOfDay()])
    //         ->latest('tanggal_bayar')
    //         ->get();
            
    //     return [$pembayarans, $startDate, $endDate];
    // }
}

