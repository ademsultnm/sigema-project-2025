@extends('backend.layouts.app')
@section('title', 'Edit Absensi Siswa')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Edit Absensi Siswa</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Absensi untuk: <strong>{{ $absensi_siswa->siswa->nama ?? 'Siswa tidak ditemukan' }}</strong></h5>
                        </div>
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

                            <form method="POST" action="{{ route('absensi_siswa.update', $absensi_siswa->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal Absensi</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $absensi_siswa->tanggal) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kehadiran">Status Kehadiran</label>
                                            <select class="form-control form-select" id="kehadiran" name="kehadiran" required>
                                                <option value="hadir" {{ old('kehadiran', $absensi_siswa->kehadiran) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="izin" {{ old('kehadiran', $absensi_siswa->kehadiran) == 'izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="sakit" {{ old('kehadiran', $absensi_siswa->kehadiran) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                <option value="tidak_hadir" {{ old('kehadiran', $absensi_siswa->kehadiran) == 'tidak_hadir' ? 'selected' : '' }}>Alpha (Tidak Hadir)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('absensi_siswa.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
