@extends('backend.layouts.app')
@section('title', 'Detail guru')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Detail Guru</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Diri Guru</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Guru</label>
                                <input type="text" class="form-control" id="nama"
                                    value="{{ $guru->nama }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="mata_pelajaran">Mata Pelajaran</label>
                                <input type="text" class="form-control" id="mata_pelajaran"
                                    value="{{ $guru->mata_pelajaran }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="jenjang">Jenjang</label>
                                <input type="text" class="form-control" id="jenjang"
                                    value="{{ $guru->jenjang }}" readonly>
                            </div>

                            <hr>
                            <h4 class="mt-4">Detail Akun Login</h4>

                            {{-- Pengecekan apakah relasi user ada --}}
                            @if ($guru->user)
                                <div class="form-group">
                                    <label for="email">Email Akun</label>
                                    <input type="email" class="form-control" id="email"
                                        value="{{ $guru->user->email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" id="role"
                                        value="{{ $guru->user->role }}" readonly>
                                </div>
                            @else
                                {{-- Pesan jika guru belum memiliki akun user --}}
                                <div class="alert alert-light-warning color-warning">
                                    <h4 class="alert-heading">Akun Belum Dibuat</h4>
                                    <p>Data akun login untuk guru ini belum ada. Hanya Super Admin yang bisa membuat akun .</p>
                                </div>
                            @endif

                            <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>

                            {{-- Tombol Edit dan Hapus hanya untuk Super Admin --}}
                            @if(strtolower(auth()->user()->role) === 'super admin')
                                <a href="{{ route('guru.edit', $guru) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('guru.destroy', $guru) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini beserta akunnya?')">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

