@extends('backend.layouts.app')
@section('title', 'Input Nilai Baru')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Input Nilai Siswa </h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    {{-- KARTU UNTUK MEMILIH KELAS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5>Pilih Kelas</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('nilai.create') }}">
                                <div class="row align-items-end">
                                    <div class="col-md-10">
                                        <label for="kelas_id">Pilih kelas untuk menampilkan daftar siswa:</label>
                                        <select class="form-control form-select" id="kelas_id_filter" name="kelas_id" required>
                                            <option value="" disabled selected>-- Pilih Kelas --</option>
                                            @foreach ($semuaKelas as $k)
                                                {{-- Tandai kelas yang sedang dipilih --}}
                                                <option value="{{ $k->id }}" {{ ($kelasTerpilih && $kelasTerpilih->id == $k->id) ? 'selected' : '' }}>
                                                    {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Tampilkan Siswa</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- TAMPILKAN FORM INPUT NILAI HANYA JIKA KELAS SUDAH DIPILIH --}}
                    @if ($kelasTerpilih)
                        <div class="card">
                            <div class="card-header">
                                <h5>Input Detail & Nilai {{ $kelasTerpilih->nama }}</h5>
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

                                <form method="POST" action="{{ route('nilai.store') }}">
                                    @csrf
                                    {{-- Simpan ID kelas yang dipilih --}}
                                    <input type="hidden" name="kelas_id" value="{{ $kelasTerpilih->id }}">

                                    <h6>Detail Penilaian</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mata_pelajaran_id">Mata Pelajaran</label>
                                                <select class="form-control form-select" name="mata_pelajaran_id" required>
                                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                                    @foreach ($mataPelajarans as $mapel)
                                                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="guru_id">Guru Penilai</label>
                                                <select class="form-control form-select" name="guru_id" required>
                                                    @foreach ($gurus as $guru)
                                                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tipe_nilai">Tipe Nilai</label>
                                                <select class="form-control form-select" name="tipe_nilai" required>
                                                    <option value="Tugas">Tugas</option>
                                                    <option value="Ulangan Harian">Ulangan Harian</option>
                                                    <option value="UTS">UTS</option>
                                                    <option value="UAS">UAS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" name="deskripsi" placeholder="Contoh: Tugas 1 - Bab Integral, Ulangan Harian Bab 3" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tanggal_penilaian">Tanggal Penilaian</label>
                                                <input type="date" class="form-control" name="tanggal_penilaian" value="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tahun_ajaran">Tahun Ajaran</label>
                                                <input type="text" class="form-control" name="tahun_ajaran" value="{{ old('tahun_ajaran', now()->year . '/' . (now()->year + 1)) }}" placeholder="Contoh: 2025/2026" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="semester">Semester</label>
                                                <select class="form-control form-select" name="semester" required>
                                                    <option value="Ganjil">Ganjil</option>
                                                    <option value="Genap">Genap</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <h6>Input Nilai Siswa</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th>Nama Siswa</th>
                                                    <th style="width: 20%;">Input Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($siswas as $siswa)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $siswa->nama }}</td>
                                                        <td>
                                                            {{-- Nama input menggunakan array, contoh: nilai[1], nilai[2] --}}
                                                            <input type="number" step="0.01" class="form-control" name="nilai[{{ $siswa->id }}]" min="0" max="100" placeholder="0-100">
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">Tidak ada siswa di kelas ini.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary mt-3">Batal</a>
                                    <button type="submit" class="btn btn-primary mt-3" {{ $siswas->isEmpty() ? 'disabled' : '' }}>Simpan Semua Nilai</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

