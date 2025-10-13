@extends('backend.layouts.app')
@section('title', 'Daftar Waka Kurikulum')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Daftar Waka Kurikulum</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Daftar Akun Waka Kurikulum</div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <a href="{{ route('waka.create') }}" class="btn btn-primary mb-3">Tambah Waka Kurikulum</a>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($wakakurikulums as $waka)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $waka->name }}</td>
                                            <td>{{ $waka->email }}</td>
                                            <td><span class="badge bg-success">{{ $waka->role }}</span></td>
                                            <td>
                                                <form action="{{ route('waka.destroy', $waka->id) }}" method="POST" class="d-inline">
                                                    <a href="{{ route('waka.show', $waka->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                    <a href="{{ route('waka.edit', $waka->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data Waka Kurikulum.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {!! $wakakurikulums->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

