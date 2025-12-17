@extends('backend.layouts.app')
@section('title', 'Laporan Keuangan')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>
        
        <div class="page-heading">
            <h3>Laporan Keuangan SPP</h3>
        </div>

        <div class="page-content">
            {{-- KARTU TOTAL --}}
            <div class="row">
                <div class="col-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Pemasukan (Filter Ini)</h6>
                                    <h6 class="font-extrabold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Tunggakan (Semua Waktu)</h6>
                                    <h6 class="font-extrabold mb-0">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Rincian Pemasukan (Tagihan Lunas)</h4>
                            <p class="text-muted">Menampilkan data pembayaran dari <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong> sampai <strong>{{ \Carbon\Carbon::parse($endDateDisplay)->format('d M Y') }}</strong></p>
                        </div>

                        <div class="card-body">
                            {{-- FORM FILTER --}}
                            <form method="GET" action="{{ route('laporan-keuangan.index') }}" class="mb-4">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="start_date">Dari Tanggal:</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="end_date">Sampai Tanggal:</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDateDisplay }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Terapkan Filter</button>
                                    </div>
                                </div>
                            </form>
                            
                            {{-- TOMBOL DOWNLOAD --}}
                            <div class="mb-3 d-flex gap-2">
                                <a href="{{ route('laporan-keuangan.pdf', ['start_date' => $startDate, 'end_date' => $endDateDisplay]) }}" class="btn btn-danger" target="_blank"><i class="bi bi-file-earmark-pdf-fill"></i> Download PDF</a>
                            </div>

                            {{-- TABEL DATA --}}
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Lunas</th>
                                            <th>Nama Siswa</th>
                                            <th>Deskripsi Tagihan</th>
                                            <th>Jumlah</th>
                                            <th>Metode Bayar</th>
                                            <th>Tahun Ajaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($laporanPemasukan as $item)
                                            <tr>
                                                {{-- Menggunakan updated_at sebagai tanggal pelunasan --}}
                                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y, H:i') }}</td>
                                                
                                                <td>{{ $item->siswa->nama ?? 'Siswa Dihapus' }}</td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td class="text-success fw-bold">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</td>
                                                
                                                {{-- Logika Menampilkan Metode --}}
                                                <td>
                                                    @if(!empty($item->payment_channel))
                                                        <span class="badge bg-light-primary text-primary">{{ strtoupper($item->payment_channel) }}</span>
                                                    @else
                                                        <span class="badge bg-light-secondary text-secondary">MANUAL / TUNAI</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->tahun_ajaran }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-muted">Tidak ada pemasukan pada rentang tanggal ini.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <td colspan="3" class="text-end fw-bold">TOTAL PEMASUKAN</td>
                                            <td colspan="3" class="fw-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection