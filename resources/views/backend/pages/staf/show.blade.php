@extends('backend.layouts.app')
@section('title', 'Detail Staf Keuangan')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Detail Staf Keuangan</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Detail Akun</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $stafkeuangan->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat Email</label>
                                <input type="email" class="form-control" value="{{ $stafkeuangan->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" class="form-control" value="{{ $stafkeuangan->role }}" readonly>
                            </div>
                             <div class="form-group">
                                <label>Akun Dibuat Pada</label>
                                <input type="text" class="form-control" value="{{ $stafkeuangan->created_at->format('d F Y H:i') }}" readonly>
                            </div>
                            <a href="{{ route('staf.index') }}" class="btn btn-secondary">Kembali</a>
                            <a href="{{ route('staf.edit', $stafkeuangan->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

