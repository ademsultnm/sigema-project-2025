<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\PembayaranSpp;
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
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        list($pembayarans, $startDate, $endDate) = $this->getLaporanData($request);

        $totalPemasukan = $pembayarans->sum('jumlah_bayar');
        $totalTunggakan = TagihanSpp::where('status', 'Belum Lunas')->sum('jumlah_tagihan');

        return view('backend.pages.laporan_keuangan.index', compact(
            'pembayarans',
            'totalPemasukan',
            'totalTunggakan',
            'startDate',
            'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        list($pembayarans, $startDate, $endDate) = $this->getLaporanData($request);
        $totalPemasukan = $pembayarans->sum('jumlah_bayar');

        $pdf = PDF::loadView('backend.pages.laporan_keuangan.pdf', compact('pembayarans', 'startDate', 'endDate', 'totalPemasukan'));
        
        return $pdf->stream('laporan-keuangan-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        return Excel::download(new LaporanKeuanganExport($startDate, $endDate), 'laporan-keuangan-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    private function getLaporanData(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $pembayarans = PembayaranSpp::with('siswa', 'verifikator', 'tagihan')
            ->where('status_verifikasi', 'Terverifikasi')
            ->whereBetween('tanggal_bayar', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->latest('tanggal_bayar')
            ->get();
            
        return [$pembayarans, $startDate, $endDate];
    }
}

