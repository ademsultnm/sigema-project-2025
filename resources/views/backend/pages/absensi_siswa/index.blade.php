@extends('backend.layouts.app')
@section('title', 'Absensi Siswa')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        {{-- ================================================================= --}}
        {{--                TAMPILAN BERDASARKAN PERAN PENGGUNA                --}}
        {{-- ================================================================= --}}

        @if (strtolower(auth()->user()->role) === 'murid')

            {{-- ---------------- TAMPILAN UNTUK SISWA ---------------- --}}
            <div class="page-heading">
                <h3>Riwayat Absensi Saya</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="card-body">
                         <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($absensiSiswa as $absensi)
                                        <tr>
                                            <td>{{ $loop->iteration + ($absensiSiswa->currentPage() - 1) * $absensiSiswa->perPage() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</td>
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada data absensi untuk Anda.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $absensiSiswa->links() }}
                    </div>
                </div>
            </div>

        @else

            {{-- ---------------- TAMPILAN UNTUK ADMIN & GURU ---------------- --}}
            <div class="page-heading">
                <h3>Rekap Absensi Siswa</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="card-header"><h4>Filter Rekap</h4></div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('absensi_siswa.index') }}">
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <label for="kelas_id">Filter Kelas</label>
                                    <select class="form-control" name="kelas_id">
                                        <option value="">Semua Kelas</option>
                                        @foreach($semuaKelas as $k)
                                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="tanggal">Filter Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ request('tanggal') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    <a href="{{ route('absensi_siswa.index') }}" class="btn btn-secondary w-100 mt-2">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                       <h5>Hasil Rekapitulasi</h5>
                        <a href="{{ route('absensi_siswa.create') }}" class="btn btn-primary">Input Absensi Baru</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kelas</th>
                                        <th class="text-center">Hadir</th>
                                        <th class="text-center">Izin</th>
                                        <th class="text-center">Sakit</th>
                                        <th class="text-center">Alpha</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rekapAbsensi as $rekap)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d F Y') }}</td>
                                            <td>{{ $rekap->kelas->nama ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $rekap->total_hadir }}</td>
                                            <td class="text-center">{{ $rekap->total_izin }}</td>
                                            <td class="text-center">{{ $rekap->total_sakit }}</td>
                                            <td class="text-center">{{ $rekap->total_alpha }}</td>
                                            <td>
                                                <a href="{{ route('absensi_siswa.show_class', ['kelas' => $rekap->kelas_id, 'tanggal' => $rekap->tanggal]) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data absensi yang cocok.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         {{ $rekapAbsensi->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

