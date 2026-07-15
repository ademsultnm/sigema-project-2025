@extends('backend.layouts.app')
@section('title', 'Nilai')
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
                <h3>Rekap Nilai Saya</h3>
                <p class="text-subtitle text-muted">Berikut adalah daftar nilai Anda yang telah diinput oleh guru.</p>
            </div>
            <div class="page-content">
                @forelse ($nilais as $namaMapel => $nilaiMapel)
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $namaMapel ?: 'Lainnya' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tipe Penilaian</th>
                                            <th>Deskripsi</th>
                                            <th class="text-center">Nilai</th>
                                            <th>Guru</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($nilaiMapel as $nilai)
                                            <tr>
                                                <td><span class="badge bg-light-info">{{ $nilai->tipe_nilai }}</span></td>
                                                <td>{{ $nilai->deskripsi }}</td>
                                                <td class="text-center"><strong class="fs-5">{{ $nilai->nilai }}</strong></td>
                                                <td>{{ $nilai->guru->nama ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($nilai->tanggal_penilaian)->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center">Belum ada nilai yang diinput untuk Anda.</p>
                        </div>
                    </div>
                @endforelse
            </div>

        @else

            {{-- ---------------- TAMPILAN UNTUK ADMIN & GURU ---------------- --}}
            <div class="page-heading">
                <h3>Daftar Nilai Siswa</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="card-header"><h4>Filter Data Nilai</h4></div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('nilai.index') }}">
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <label for="kelas_id">Filter Kelas</label>
                                    <select id="kelas_id" class="form-control" name="kelas_id">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="mata_pelajaran_id">Filter Mata Pelajaran</label>
                                    <select id="mata_pelajaran_id" class="form-control" name="mata_pelajaran_id">
                                        <option value="">Semua Mata Pelajaran</option>
                                        @foreach($mataPelajarans as $mapel)
                                            <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary w-100 mt-2">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                       <h5>Hasil Penilaian</h5>
                        <a href="{{ route('nilai.create') }}" class="btn btn-primary">Input Nilai Baru</a>
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
                                        <th>Siswa</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Deskripsi</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nilais as $nilai)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($nilai->tanggal_penilaian)->format('d/m/Y') }}</td>
                                            <td>{{ $nilai->siswa->nama ?? 'N/A' }} ({{ $nilai->kelas->nama ?? '' }})</td>
                                            <td>{{ $nilai->mataPelajaran->nama ?? 'N/A' }}</td>
                                            <td>{{ $nilai->deskripsi }}</td>
                                            <td><strong class="fs-5">{{ $nilai->nilai }}</strong></td>
                                            <td>
                                                <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus nilai ini?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data nilai yang cocok.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         {{ $nilais->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

