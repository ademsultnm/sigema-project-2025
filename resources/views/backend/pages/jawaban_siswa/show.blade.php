@extends('backend.layouts.app')
@section('title', 'Detail Jawaban')
@section('content')
<div id="main">
    <div class="page-heading">
        <h3>Detail Jawaban untuk: {{ $eLearning->judul }}</h3>
        <p class="text-subtitle text-muted">{{ $eLearning->mataPelajaran->nama ?? 'N/A' }}</p>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Siswa yang Mengumpulkan</h5>
            </div>
            <div class="card-body">
                 <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Waktu Pengumpulan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengumpulan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->waktu_pengumpulan)->format('d F Y, H:i') }}</td>
                                        <td>
                                            {{-- PERBAIKAN: Mengubah route, target, ikon, dan teks --}}
                                            <a href="{{ route('jawaban-siswa.view', $item->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                <i class="bi bi-eye"></i> Lihat Jawaban
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada siswa yang mengumpulkan jawaban untuk tugas ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                         <a href="{{ route('jawaban-siswa.index') }}" class="btn btn-secondary">Kembali ke Daftar Tugas</a>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

