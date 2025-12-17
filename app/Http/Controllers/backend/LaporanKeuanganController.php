<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganExport;

class LaporanKeuanganController extends Controller
{
    /**
     * Menampilkan halaman laporan keuangan.
     */
    public function index(Request $request)
    {
        // 1. Validasi Filter Tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // 2. Tentukan Rentang Tanggal (Default: Awal Bulan s/d Akhir Bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endInput  = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        
        // Konversi end_date agar mencakup sampai jam terakhir (23:59:59)
        $endDate   = Carbon::parse($endInput)->endOfDay();

        // 3. QUERY PEMASUKAN: Ambil Tagihan yang statusnya 'Lunas'
        // Kita gunakan 'updated_at' sebagai asumsi waktu pelunasan
        $laporanPemasukan = TagihanSpp::with('siswa')
            ->where('status', 'Lunas')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->latest('updated_at') // Urutkan dari yang baru lunas
            ->get();

        // 4. Hitung Total Pemasukan (Sesuai Filter Tanggal)
        $totalPemasukan = $laporanPemasukan->sum('jumlah_tagihan');

        // 5. Hitung Total Tunggakan (Keseluruhan / All Time)
        // Ini menghitung potensi uang yang belum masuk
        $totalTunggakan = TagihanSpp::where('status', 'Belum Lunas')->sum('jumlah_tagihan');

        // Variabel untuk tampilan tanggal di input form (format Y-m-d)
        $endDateDisplay = Carbon::parse($endInput)->toDateString();

        return view('backend.pages.laporan_keuangan.index', compact(
            'laporanPemasukan',
            'totalPemasukan',
            'totalTunggakan',
            'startDate',
            'endDateDisplay'
        ));
    }

    /**
     * Export Laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        // Logika tanggal sama dengan index
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endInput  = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $endDate   = Carbon::parse($endInput)->endOfDay();

        // Query Data
        $laporanPemasukan = TagihanSpp::with('siswa')
            ->where('status', 'Lunas')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->oldest('updated_at') // Urutkan dari terlama ke terbaru untuk laporan
            ->get();

        $totalPemasukan = $laporanPemasukan->sum('jumlah_tagihan');
        $endDateDisplay = Carbon::parse($endInput)->toDateString();

        // Load View PDF
        // Pastikan file view 'backend.pages.laporan_keuangan.pdf' sudah ada dan disesuaikan variabelnya
        $pdf = PDF::loadView('backend.pages.laporan_keuangan.pdf', compact(
            'laporanPemasukan', 
            'startDate', 
            'endDateDisplay', 
            'totalPemasukan'
        ));
        
        return $pdf->stream('laporan-keuangan-' . $startDate . '-sd-' . $endDateDisplay . '.pdf');
    }

    /**
     * Export Laporan ke Excel (Opsional)
     */
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Pastikan class LaporanKeuanganExport juga sudah disesuaikan query-nya ke TagihanSpp
        return Excel::download(new LaporanKeuanganExport($startDate, $endDate), 'laporan-keuangan-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }
}