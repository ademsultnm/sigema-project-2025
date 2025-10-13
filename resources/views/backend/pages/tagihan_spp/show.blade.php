@extends('backend.layouts.app')
@section('title', 'Detail Tagihan SPP')
@section('content')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
    </header>

    <div class="page-heading">
        <h3>Detail Tagihan SPP</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Informasi Tagihan</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <p class="form-control-static">{{ $tagihanSpp->siswa->nama ?? 'Siswa tidak ditemukan' }}</p>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <p class="form-control-static">{{ $tagihanSpp->deskripsi }}</p>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Tagihan</label>
                            <p class="form-control-static">Rp {{ number_format($tagihanSpp->jumlah_tagihan, 0, ',', '.') }}</p>
                        </div>
                        <div class="form-group">
                            <label>Jatuh Tempo</label>
                            <p class="form-control-static">{{ \Carbon\Carbon::parse($tagihanSpp->jatuh_tempo)->format('d F Y') }}</p>
                        </div>
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <p class="form-control-static">{{ $tagihanSpp->tahun_ajaran }}</p>
                        </div>
                        <div class="form-group">
                            <label>Status Pembayaran</label>
                            <p class="form-control-static">
                                @if($tagihanSpp->status == 'Lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </p>
                        </div>
                        <hr>
                        <a href="{{ route('tagihan-spp.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                        <a href="{{ route('tagihan-spp.edit', $tagihanSpp->id) }}" class="btn btn-primary">Edit Tagihan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
