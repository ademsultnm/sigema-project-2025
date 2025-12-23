@extends('backend.layouts.app')
@section('title', 'E-Learning')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        
        <div class="page-heading">
            <h3>Daftar E-Learning</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- UPDATE: Header dengan Layout Row untuk Filter --}}
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-2 mb-md-0">
                                    <h5 class="m-0">Daftar E-Learning</h5>
                                </div>
                                
                                {{-- BAGIAN FILTER GURU --}}
                                <div class="col-md-5 mb-2 mb-md-0">
                                    <form action="{{ route('e_learning.index') }}" method="GET">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-person-badge"></i> Filter Guru</span>
                                            <select name="guru_id" class="form-select" onchange="this.form.submit()">
                                                <option value="">-- Semua Guru --</option>
                                                @foreach ($gurus as $guru)
                                                    <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>
                                                        {{ $guru->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-3 text-md-end">
                                    <a href="{{ route('e_learning.create') }}" class="btn btn-primary w-100">
                                        <i class="bi bi-plus-circle"></i> Tambah Baru
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th scope="col">Judul</th>
                                            <th scope="col">Guru</th>
                                            <th scope="col">Kelas Ditugaskan</th>
                                            <th scope="col">File</th>
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($eLearnings as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + ($eLearnings->currentPage() - 1) * $eLearnings->perPage() }}</td>
                                                <td>
                                                    <span class="fw-bold">{{ $item->judul }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($item->deskripsi, 30) }}</small>
                                                </td>
                                                <td>{{ $item->guru->nama ?? 'N/A' }}</td>
                                                <td>
                                                    @forelse($item->kelas as $kelas)
                                                        <span class="badge bg-light-primary text-primary mb-1">{{ $kelas->nama }}</span>
                                                    @empty
                                                        <span class="badge bg-light-secondary text-secondary">Belum ditugaskan</span>
                                                    @endforelse
                                                </td>
                                                <td>
                                                    @if ($item->file_name)
                                                        <a href="{{ route('e_learning.download', $item->id) }}" class="btn btn-success btn-sm" title="Download File">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $item->tipe == 'tugas' ? 'bg-light-danger text-danger' : 'bg-light-info text-info' }}">
                                                        {{ ucfirst($item->tipe) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('e_learning.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                                        <a href="{{ route('e_learning.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                                        <form action="{{ route('e_learning.destroy', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <img src="{{ asset('assets/images/samples/error-404.png') }}" alt="No Data" style="height: 100px; opacity: 0.5">
                                                    <p class="mt-2 text-muted">Belum ada materi atau tugas yang diunggah.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            {{-- UPDATE: Gunakan withQueryString agar filter tidak hilang saat pindah page --}}
                            <div class="mt-4">
                                {{ $eLearnings->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection