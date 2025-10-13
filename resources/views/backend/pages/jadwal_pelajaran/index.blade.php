@extends('backend.layouts.app')
@section('title', 'Kelola Jadwal Pelajaran')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>
        
        <div class="page-heading">
            <h3>Kelola Jadwal Pelajaran</h3>
            <p class="text-subtitle text-muted">Atur jadwal pelajaran mingguan untuk setiap kelas.</p>
        </div>

        <div class="page-content">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                   <h5>Jadwal Mingguan</h5>
                    <a href="{{ route('jadwal-pelajaran.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 12%;">Hari</th>
                                    <th>Jadwal Pelajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($days as $day)
                                    <tr>
                                        <td><strong>{{ $day }}</strong></td>
                                        <td>
                                            @if (isset($jadwals[$day]) && $jadwals[$day]->count() > 0)
                                                <ul class="list-group list-group-flush">
                                                @foreach ($jadwals[$day]->groupBy('kelas.nama') as $namaKelas => $jadwalKelas)
                                                    <li class="list-group-item">
                                                        <strong class="d-block mb-2">{{ $namaKelas }}</strong>
                                                        @foreach($jadwalKelas as $jadwal)
                                                            <div class="d-flex justify-content-between align-items-center mb-1 border-bottom py-1">
                                                                <div>
                                                                    <span class="badge bg-primary">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                                                                    <strong>{{ $jadwal->mataPelajaran->nama ?? 'N/A' }}</strong>
                                                                    <small class="text-muted d-block">oleh {{ $jadwal->guru->nama ?? 'N/A' }}</small>
                                                                </div>
                                                                <div>
                                                                    <a href="{{ route('jadwal-pelajaran.edit', $jadwal->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                                                    <form action="{{ route('jadwal-pelajaran.destroy', $jadwal->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus jadwal ini?')"><i class="bi bi-trash"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </li>
                                                @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted text-center my-3">Tidak ada jadwal</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
