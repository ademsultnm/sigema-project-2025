@extends('backend.layouts.app')
@section('title', 'Daftar Staf Keuangan')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Daftar Staf Keuangan</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Daftar Akun Staf Keuangan</div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <a href="{{ route('staf.create') }}" class="btn btn-primary mb-3">Tambah Akun</a>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stafkeuangans as $staf)
                                            <tr>
                                                <td>{{ $loop->iteration + $stafkeuangans->firstItem() - 1 }}</td>
                                                <td>{{ $staf->name }}</td>
                                                <td>{{ $staf->email }}</td>
                                                <td><span class="badge bg-light-success">{{ $staf->role }}</span></td>
                                                <td>
                                                    <a href="{{ route('staf.show', $staf->id) }}"
                                                        class="btn btn-info btn-sm">Detail</a>
                                                    <a href="{{ route('staf.edit', $staf->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('staf.destroy', $staf->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data Staf Keuangan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                {{ $stafkeuangans->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

