@extends('backend.layouts.app')
@section('title', 'Buat Tagihan SPP')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Buat Tagihan SPP Baru</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Form Tagihan</div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('tagihan-spp.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="siswa_id">Pilih Siswa</label>
                                    <select class="form-control" id="siswa_id" name="siswa_id" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach ($siswas as $siswa)
                                            <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }} (Jenjang: {{ $siswa->jenjang }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Tagihan</label>
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', 'SPP Bulan ' . now()->format('F Y')) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah_tagihan">Jumlah Tagihan (Rp)</label>
                                    <input type="number" class="form-control" id="jumlah_tagihan" name="jumlah_tagihan" value="{{ old('jumlah_tagihan') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="jatuh_tempo">Tanggal Jatuh Tempo</label>
                                    <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran</label>
                                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', now()->year . '/' . (now()->year + 1)) }}" placeholder="Contoh: 2025/2026" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Belum Lunas" {{ old('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="Lunas" {{ old('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('tagihan-spp.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
