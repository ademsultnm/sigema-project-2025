@extends('backend.layouts.app')
@section('title', 'Detail Admin')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Detail Admin</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Detail Akun Admin</div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama"
                                    value="{{ $admin->name }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="text" class="form-control" id="email"
                                    value="{{ $admin->email }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" id="role"
                                    value="{{ $admin->role }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="created_at">Tanggal Dibuat</label>
                                <input type="text" class="form-control" id="created_at"
                                    value="{{ $admin->created_at->format('d F Y H:i') }}" readonly>
                            </div>

                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Kembali</a>
                            <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
