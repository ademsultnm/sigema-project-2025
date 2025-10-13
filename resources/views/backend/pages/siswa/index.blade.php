@extends('backend.layouts.app')
@section('title', 'Kelola Siswa')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>
        
        <div class="page-heading">
            <h3>Kelola Data Siswa</h3>
        </div>

        <div class="page-content">
            {{-- FORM FILTER --}}
            <div class="card">
                <div class="card-header">
                    <h4>Filter Data Siswa</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('siswa.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search">Cari Nama atau NIS</label>
                                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Masukkan nama atau NIS...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="jenjang">Filter Jenjang</label>
                                    <select id="jenjang" class="form-control" name="jenjang">
                                        <option value="">Semua Jenjang</option>
                                        <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kelas_id">Filter Kelas</label>
                                    <select id="kelas_id" class="form-control" name="kelas_id">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                <a href="{{ route('siswa.index') }}" class="btn btn-secondary w-100 mt-2">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL DATA SISWA --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                   <h5>Daftar Siswa</h5>
                    <a href="{{ route('siswa.create') }}" class="btn btn-primary">Tambah Siswa</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                     @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Jenjang</th>
                                    <th>Kelas Saat Ini</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswas as $siswa)
                                    <tr>
                                        <td><strong>{{ $siswa->nis }}</strong></td>
                                        <td>{{ $siswa->nama }}</td>
                                        <td>{{ $siswa->jenjang }}</td>
                                        <td>
                                            @if($siswa->kelas->isNotEmpty())
                                                {{ $siswa->kelas->last()->nama }} 
                                                <span class="text-muted">({{ $siswa->kelas->last()->pivot->tahun_ajaran }})</span>
                                            @else
                                                <span class="badge bg-light-secondary">Belum ada kelas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus siswa ini beserta akunnya?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data siswa yang cocok dengan filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     {{ $siswas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

