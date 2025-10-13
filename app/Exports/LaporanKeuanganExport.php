<?php

namespace App\Exports;

use App\Models\PembayaranSpp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LaporanKeuanganExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return PembayaranSpp::with('siswa', 'verifikator', 'tagihan')
            ->where('status_verifikasi', 'Terverifikasi')
            ->whereBetween('tanggal_bayar', [$this->startDate, Carbon::parse($this->endDate)->endOfDay()])
            ->latest('tanggal_bayar');
    }

    public function headings(): array
    {
        return [
            'Tanggal Bayar',
            'Nama Siswa',
            'Deskripsi Tagihan',
            'Jumlah',
            'Metode Pembayaran',
            'Diverifikasi Oleh',
        ];
    }

    public function map($pembayaran): array
    {
        return [
            Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i'),
            $pembayaran->siswa->nama ?? 'N/A',
            $pembayaran->tagihan->deskripsi ?? 'N/A',
            $pembayaran->jumlah_bayar,
            $pembayaran->metode_pembayaran,
            $pembayaran->verifikator->name ?? 'N/A',
        ];
    }
}
