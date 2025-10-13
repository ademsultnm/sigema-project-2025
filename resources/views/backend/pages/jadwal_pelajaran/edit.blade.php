@extends('backend.layouts.app')
@section('title', 'Edit Jadwal')
@section('content')
    <div id="main">
        <div class="page-heading">
            <h3>Edit Jadwal Pelajaran</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h5>Form Edit Jadwal</h5></div>
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

                            <form method="POST" action="{{ route('jadwal-pelajaran.update', $jadwalPelajaran->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kelas_id">Kelas</label>
                                            <select class="form-control form-select" name="kelas_id" required>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ old('kelas_id', $jadwalPelajaran->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mata_pelajaran_id">Mata Pelajaran</label>
                                            <select class="form-control form-select" name="mata_pelajaran_id" required>
                                                @foreach ($mataPelajarans as $mapel)
                                                    <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $jadwalPelajaran->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guru_id">Guru</label>
                                            <select class="form-control form-select" name="guru_id" required>
                                                @foreach ($gurus as $guru)
                                                    <option value="{{ $guru->id }}" {{ old('guru_id', $jadwalPelajaran->guru_id) == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hari">Hari</label>
                                            <select class="form-control form-select" name="hari" required>
                                                <option value="Senin" {{ old('hari', $jadwalPelajaran->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                                <option value="Selasa" {{ old('hari', $jadwalPelajaran->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                                <option value="Rabu" {{ old('hari', $jadwalPelajaran->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                                <option value="Kamis" {{ old('hari', $jadwalPelajaran->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                                <option value="Jumat" {{ old('hari', $jadwalPelajaran->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                                <option value="Sabtu" {{ old('hari', $jadwalPelajaran->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_mulai">Jam Mulai</label>
                                            <input type="time" class="form-control" name="jam_mulai" value="{{ old('jam_mulai', $jadwalPelajaran->jam_mulai) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_selesai">Jam Selesai</label>
                                            <input type="time" class="form-control" name="jam_selesai" value="{{ old('jam_selesai', $jadwalPelajaran->jam_selesai) }}" required>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran</label>
                                            <input type="text" class="form-control" name="tahun_ajaran" value="{{ old('tahun_ajaran', $jadwalPelajaran->tahun_ajaran) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="semester">Semester</label>
                                            <select class="form-control form-select" name="semester" required>
                                                <option value="Ganjil" {{ old('semester', $jadwalPelajaran->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                                <option value="Genap" {{ old('semester', $jadwalPelajaran->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary mt-3">Batal</a>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
