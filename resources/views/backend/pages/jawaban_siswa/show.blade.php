@extends('backend.layouts.app')
@section('title', 'Detail Jawaban')
@section('content')
<div id="main">
    <div class="page-heading">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Detail Jawaban: {{ $eLearning->judul }}</h3>
                <p class="text-subtitle text-muted">
                    Mata Pelajaran: <span class="badge bg-light-primary text-primary">{{ $eLearning->mataPelajaran->nama ?? 'N/A' }}</span>
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('jawaban-siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h5 class="m-0">Daftar Siswa yang Mengumpulkan</h5>
                    </div>
                    
                    {{-- FORM FILTER KELAS --}}
                    <div class="col-md-6">
                        <form action="{{ route('jawaban-siswa.show', $eLearning->id) }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-filter"></i> Filter Kelas</span>
                                <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                 <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th> {{-- KOLOM BARU --}}
                                    <th>Waktu Pengumpulan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengumpulan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}</span>
                                        </td>
                                        
                                        {{-- MENAMPILKAN KELAS --}}
                                        <td>
                                            @if($item->siswa && $item->siswa->kelas->isNotEmpty())
                                                {{-- Mengambil kelas terakhir (terbaru) --}}
                                                <span class="badge bg-light-info text-info">
                                                    {{ $item->siswa->kelas->last()->nama }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($item->waktu_pengumpulan)->format('d F Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('jawaban-siswa.view', $item->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                                <i class="bi bi-file-earmark-text"></i> Lihat File
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <img src="{{ asset('assets/images/samples/error-404.png') }}" alt="No Data" style="height: 80px; opacity: 0.5">
                                            <p class="mt-2 text-muted">
                                                @if(request('kelas_id'))
                                                    Tidak ada jawaban siswa dari kelas yang dipilih.
                                                @else
                                                    Belum ada siswa yang mengumpulkan jawaban untuk tugas ini.
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection