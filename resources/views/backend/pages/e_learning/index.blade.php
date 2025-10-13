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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Daftar E-Learning</h5>
                            <a href="{{ route('e_learning.create') }}" class="btn btn-primary">Tambah E-Learning</a>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
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
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->guru->nama ?? 'N/A' }}</td>
                                                <td>
                                                    @forelse($item->kelas as $kelas)
                                                        <span class="badge bg-light-primary">{{ $kelas->nama }}</span>
                                                    @empty
                                                        <span class="badge bg-light-secondary">Belum ditugaskan</span>
                                                    @endforelse
                                                </td>
                                                <td>
                                                    @if ($item->file_name)
                                                        <a href="{{ route('e_learning.download', $item->id) }}" class="btn btn-success btn-sm">
                                                            <i class="bi bi-download"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="badge bg-light-secondary">Tidak ada</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $item->tipe == 'tugas' ? 'bg-light-danger' : 'bg-light-info' }}">
                                                        {{ ucfirst($item->tipe) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('e_learning.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                                    <a href="{{ route('e_learning.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                                    <form action="{{ route('e_learning.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data E-Learning.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                             {{ $eLearnings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

