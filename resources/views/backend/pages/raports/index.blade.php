@extends('backend.layouts.app')
@section('title', 'Daftar Raport')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Daftar Raport Siswa</h3>
        </div>

        <div class="page-content">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Filter & Data Raport</h5>
                </div>
                <div class="card-body">
                    {{-- FORM FILTER --}}
                    <form method="GET" action="{{ route('raports.index') }}" class="mb-4">
                        <div class="row g-3">
                            {{-- Filter Nama --}}
                            <div class="col-md-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="text" name="nama_siswa" class="form-control" placeholder="Cari nama..." value="{{ request('nama_siswa') }}">
                            </div>

                            {{-- Filter Kelas --}}
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Mapel --}}
                            <div class="col-md-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="mata_pelajaran_id" class="form-select">
                                    <option value="">-- Semua Mapel --</option>
                                    @foreach ($mataPelajaranList as $mapel)
                                        <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Tahun Ajaran --}}
                            <div class="col-md-3">
                                <label class="form-label">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" class="form-control" placeholder="Cth: 2025/2026" value="{{ request('tahun_ajaran') }}">
                            </div>

                            <div class="col-12 d-flex justify-content-between align-items-end mt-3">
                                <div>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Terapkan Filter</button>
                                    <a href="{{ route('raports.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                                
                               <div>
    {{-- Tombol PDF --}}
    <a href="{{ route('raports.export_pdf', request()->all()) }}" class="btn btn-danger" target="_blank">
        <i class="bi bi-file-earmark-pdf"></i> Download 
    </a>
    
    <a href="{{ route('raports.create') }}" class="btn btn-info text-white">
        <i class="bi bi-plus"></i> Tambah Raport
    </a>
</div>
                            </div>
                        </div>
                    </form>

                    {{-- TABEL DATA --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Semester</th>
                                    <th>Rata-rata</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($raports as $raport)
                                    <tr>
                                        <td>{{ $loop->iteration + ($raports->currentPage() - 1) * $raports->perPage() }}</td>
                                        <td>{{ $raport->siswa->nama ?? 'Siswa Dihapus' }}</td>
                                        
                                        {{-- Logika Menampilkan Kelas (Many-to-Many) --}}
                                        <td>
                                            @if($raport->siswa && $raport->siswa->kelas->isNotEmpty())
                                                {{ $raport->siswa->kelas->last()->nama }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- Menampilkan Mapel (Asumsi ada relasi mataPelajaran) --}}
                                        <td>{{ $raport->mataPelajaran->nama ?? '-' }}</td>
                                        
                                        <td>{{ $raport->semester }} <br> <small class="text-muted">{{ $raport->tahun_ajaran }}</small></td>
                                        
                                        <td class="fw-bold">{{ $raport->rata_rata_nilai }}</td>
                                        <td>{{ $raport->keterangan }}</td>
                                        <td>
                                            <a href="{{ route('raports.show', $raport->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('raports.edit', $raport->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('raports.destroy', $raport->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data raport tidak ditemukan dengan filter tersebut.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $raports->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection