@extends('backend.layouts.app')
@section('title', 'Edit Nilai')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Edit Nilai Siswa</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h5>Form Edit Penilaian</h5></div>
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

                            <form method="POST" action="{{ route('nilai.update', $nilai->id) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kelas_id">Kelas</label>
                                            <select class="form-control form-select" id="kelas_id" name="kelas_id" required>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ old('kelas_id', $nilai->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="siswa_id">Siswa</label>
                                            <select class="form-control form-select" id="siswa_id" name="siswa_id" required>
                                                @foreach ($siswas as $siswa)
                                                    <option value="{{ $siswa->id }}" {{ old('siswa_id', $nilai->siswa_id) == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mata_pelajaran_id">Mata Pelajaran</label>
                                            <select class="form-control form-select" name="mata_pelajaran_id" required>
                                                @foreach ($mataPelajarans as $mapel)
                                                    <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $nilai->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guru_id">Guru Penilai</label>
                                            <select class="form-control form-select" name="guru_id" required>
                                                @foreach ($gurus as $guru)
                                                    <option value="{{ $guru->id }}" {{ old('guru_id', $nilai->guru_id) == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <h6>Detail Penilaian</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipe_nilai">Tipe Nilai</label>
                                            <select class="form-control form-select" name="tipe_nilai" required>
                                                <option value="Tugas" {{ old('tipe_nilai', $nilai->tipe_nilai) == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                                <option value="Ulangan Harian" {{ old('tipe_nilai', $nilai->tipe_nilai) == 'Ulangan Harian' ? 'selected' : '' }}>Ulangan Harian</option>
                                                <option value="UTS" {{ old('tipe_nilai', $nilai->tipe_nilai) == 'UTS' ? 'selected' : '' }}>UTS</option>
                                                <option value="UAS" {{ old('tipe_nilai', $nilai->tipe_nilai) == 'UAS' ? 'selected' : '' }}>UAS</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <input type="text" class="form-control" name="deskripsi" value="{{ old('deskripsi', $nilai->deskripsi) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nilai">Nilai</label>
                                            <input type="number" step="0.01" class="form-control" name="nilai" value="{{ old('nilai', $nilai->nilai) }}" min="0" max="100" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tanggal_penilaian">Tanggal Penilaian</label>
                                            <input type="date" class="form-control" name="tanggal_penilaian" value="{{ old('tanggal_penilaian', $nilai->tanggal_penilaian) }}" required>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran</label>
                                            <input type="text" class="form-control" name="tahun_ajaran" value="{{ old('tahun_ajaran', $nilai->tahun_ajaran) }}" required>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="semester">Semester</label>
                                            <select class="form-control form-select" name="semester" required>
                                                <option value="Ganjil" {{ old('semester', $nilai->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                                <option value="Genap" {{ old('semester', $nilai->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('nilai.index') }}" class="btn btn-secondary mt-3">Batal</a>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
