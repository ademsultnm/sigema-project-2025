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
                <div class="card-header">
                    <h5>Daftar Tugas Terkumpul</h5>
                </div>
                <div class="card-body">
                     @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                        <td>{{ $tugas->judul }}</td>
                                        <td>{{ $tugas->mataPelajaran->nama ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $tugas->pengumpulan_tugas_count }}</td>
                                        <td>
                                            {{-- PERBAIKAN DI SINI: Mengubah nama parameter agar cocok dengan rute --}}
                                            <a href="{{ route('jawaban-siswa.show', ['eLearning' => $tugas->id]) }}" class="btn btn-info btn-sm">Lihat Jawaban</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada siswa yang mengumpulkan jawaban.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $tugasDenganJawaban->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

