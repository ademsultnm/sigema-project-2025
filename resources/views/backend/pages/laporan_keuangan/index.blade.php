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
            <div class="row">
                <div class="col-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Pemasukan (Terverifikasi)</h6>
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
                                        <i class="iconly-boldDanger"></i>
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
                            <h4>Rincian Pemasukan</h4>
                            <p class="text-muted">Menampilkan pembayaran terverifikasi dari <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong> sampai <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong></p>
                        </div>

                        <div class="card-body">
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
                                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">Filter Laporan</button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="mb-3 d-flex gap-2">
                                <a href="{{ route('laporan-keuangan.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-danger" target="_blank"><i class="bi bi-file-earmark-pdf-fill"></i> Download PDF</a>
                                {{-- <a href="{{ route('laporan-keuangan.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Download Excel</a> --}}
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Bayar</th>
                                            <th>Nama Siswa</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                            <th>Metode</th>
                                            <th>Diverifikasi Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pembayarans as $pembayaran)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y, H:i') }}</td>
                                                <td>{{ $pembayaran->siswa->nama ?? 'Siswa Dihapus' }}</td>
                                                <td>{{ $pembayaran->tagihan->deskripsi ?? 'Tagihan Dihapus' }}</td>
                                                <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                                <td>{{ $pembayaran->metode_pembayaran }}</td>
                                                <td>{{ $pembayaran->verifikator->name ?? 'N/A' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data pembayaran terverifikasi pada rentang tanggal ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

