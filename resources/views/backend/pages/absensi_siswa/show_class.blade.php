@extends('backend.layouts.app')
@section('title', 'Detail Absensi Kelas')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Detail Absensi Kelas {{ $kelas->nama }}</h3>
            <p class="text-subtitle text-muted">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</p>
        </div>

        <div class="page-content">
             <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                   <h5>Daftar Kehadiran Siswa</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Status Kehadiran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absensiSiswa as $absensi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $absensi->siswa->nama ?? 'N/A' }}</td>
                                        <td>
                                             @if($absensi->kehadiran == 'hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif($absensi->kehadiran == 'izin')
                                                <span class="badge bg-warning">Izin</span>
                                            @elseif($absensi->kehadiran == 'sakit')
                                                <span class="badge bg-info">Sakit</span>
                                            @else
                                                <span class="badge bg-danger">Alpha</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('absensi_siswa.edit', $absensi->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('absensi_siswa.destroy', $absensi->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data absensi ini?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data absensi untuk kelas dan tanggal ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('absensi_siswa.index') }}" class="btn btn-secondary">Kembali ke Rekap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
