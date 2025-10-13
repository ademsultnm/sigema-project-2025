@extends('backend.layouts.app')
@section('title', 'Daftar Guru')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Kelola Data Guru</h3>
        </div>

        <div class="page-content">
            {{-- FORM FILTER --}}
            <div class="card">
                <div class="card-header">
                    <h4>Filter Data Guru</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('guru.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Cari Nama atau Mata Pelajaran</label>
                                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Masukkan nama atau mapel...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="jenjang">Filter Jenjang</label>
                                    <select id="jenjang" class="form-control" name="jenjang">
                                        <option value="">Semua Jenjang</option>
                                        <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                <a href="{{ route('guru.index') }}" class="btn btn-secondary w-100 mt-2">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL DATA GURU --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Daftar Guru</h5>
                    <a href="{{ route('guru.create') }}" class="btn btn-primary">Tambah Guru</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                     @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email Akun</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col">Jenjang</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gurus as $guru)
                                    <tr>
                                        <td>{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
                                        <td>{{ $guru->nama }}</td>
                                        <td>{{ $guru->user->email ?? '-' }}</td>
                                        <td>{{ $guru->mata_pelajaran }}</td>
                                        <td>{{ $guru->jenjang }}</td>
                                        <td>
                                            <a href="{{ route('guru.show', $guru) }}" class="btn btn-info btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('guru.edit', $guru) }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('guru.destroy', $guru) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini beserta akunnya?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data guru yang cocok dengan filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Paginasi yang mengingat filter --}}
                    {{ $gurus->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

