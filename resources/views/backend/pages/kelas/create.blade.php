@extends('backend.layouts.app')
@section('title', 'Tambah Kelas')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Tambah Kelas Baru</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h5>Form Tambah Kelas</h5></div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('kelas_admin.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama Kelas</label>
                                    <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Contoh: VII-A, X IPA 1" required>
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label for="tingkat">Tingkat</label>
                                    <input type="number" id="tingkat" class="form-control @error('tingkat') is-invalid @enderror" name="tingkat" value="{{ old('tingkat') }}" required>
                                   
                                    <small class="form-text text-muted">Contoh: 7, 8, 9 untuk SMP; 10, 11, 12 untuk SMA.</small>
                                    @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label for="jenjang">Jenjang</label>
                                    <select id="jenjang" class="form-control @error('jenjang') is-invalid @enderror" name="jenjang" required>
                                        <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    </select>
                                    @error('jenjang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <a href="{{ route('kelas_admin.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
