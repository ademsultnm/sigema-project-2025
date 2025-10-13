@extends('backend.layouts.app')
@section('title', 'Tambah Jadwal')
@section('content')
    <div id="main">
        <div class="page-heading">
            <h3>Tambah Jadwal Baru</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h5>Form Jadwal Pelajaran</h5></div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Oops!</strong> Terjadi beberapa kesalahan:<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('jadwal-pelajaran.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kelas_id">Kelas</label>
                                            <select class="form-control form-select" name="kelas_id" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mata_pelajaran_id">Mata Pelajaran</label>
                                            <select class="form-control form-select" name="mata_pelajaran_id" required>
                                                <option value="">-- Pilih Mata Pelajaran --</option>
                                                @foreach ($mataPelajarans as $mapel)
                                                    <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guru_id">Guru</label>
                                            <select class="form-control form-select" name="guru_id" required>
                                                <option value="">-- Pilih Guru --</option>
                                                @foreach ($gurus as $guru)
                                                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hari">Hari</label>
                                            <select class="form-control form-select" name="hari" required>
                                                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                                <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                                <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                                <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                                <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                                <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_mulai">Jam Mulai</label>
                                            <input type="time" class="form-control" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_selesai">Jam Selesai</label>
                                            <input type="time" class="form-control" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran</label>
                                            <input type="text" class="form-control" name="tahun_ajaran" value="{{ old('tahun_ajaran', now()->year . '/' . (now()->year + 1)) }}" placeholder="Contoh: 2025/2026" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="semester">Semester</label>
                                            <select class="form-control form-select" name="semester" required>
                                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary mt-3">Batal</a>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Jadwal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
