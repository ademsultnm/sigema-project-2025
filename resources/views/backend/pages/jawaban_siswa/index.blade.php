@extends('backend.layouts.app')
@section('title', 'Jawaban Siswa')
@section('content')
    <div id="main">
        <div class="page-heading">
            <h3>Jawaban Tugas Siswa</h3>
            <p class="text-subtitle text-muted">Daftar tugas yang telah dikumpulkan oleh siswa.</p>
        </div>
        <div class="page-content">
            <div class="card">
                {{-- HEADER DENGAN FILTER --}}
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h5 class="m-0">Daftar Tugas Terkumpul</h5>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('jawaban-siswa.index') }}" method="GET">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-book"></i> Filter Mapel</span>
                                    <select name="mata_pelajaran_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">-- Semua Mata Pelajaran --</option>
                                        @foreach ($mataPelajarans as $mapel)
                                            <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                                {{ $mapel->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                     @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Judul Tugas</th>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center">Jumlah Pengumpul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tugasDenganJawaban as $tugas)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $tugas->judul }}</span>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($tugas->deskripsi, 40) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-primary text-primary">
                                                {{ $tugas->mataPelajaran->nama ?? 'Mapel Dihapus' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success rounded-pill">{{ $tugas->pengumpulan_tugas_count }} Siswa</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('jawaban-siswa.show', ['eLearning' => $tugas->id]) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i> Lihat Jawaban
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <img src="{{ asset('assets/images/samples/error-404.png') }}" alt="No Data" style="height: 80px; opacity: 0.5">
                                            <p class="mt-2 text-muted">Belum ada siswa yang mengumpulkan jawaban untuk filter ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination dengan withQueryString agar filter tidak hilang --}}
                    <div class="mt-4">
                        {{ $tugasDenganJawaban->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection