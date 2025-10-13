@extends('backend.layouts.app')
@section('title', 'Input Absensi Siswa')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Input Absensi Siswa</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Langkah 1: Pilih Kelas dan Tanggal</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('absensi_siswa.create') }}">
                                <div class="row align-items-end">
                                    <div class="col-md-5">
                                        <label for="kelas_id">Pilih kelas:</label>
                                        <select class="form-control form-select" name="kelas_id" required>
                                            <option value="" disabled selected>-- Pilih Kelas --</option>
                                            @foreach ($semuaKelas as $k)
                                                <option value="{{ $k->id }}" {{ ($kelasTerpilih && $kelasTerpilih->id == $k->id) ? 'selected' : '' }}>
                                                    {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="col-md-5">
                                        <label for="tanggal">Pilih Tanggal Absensi:</label>
                                        <input type="date" class="form-control" name="tanggal" value="{{ $tanggal }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Tampilkan Siswa</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($kelasTerpilih)
                        <div class="card">
                            <div class="card-header">
                                <h5>Langkah 2: Input Absensi Kelas {{ $kelasTerpilih->nama }} (Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }})</h5>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <form method="POST" action="{{ route('absensi_siswa.store') }}">
                                    @csrf
                                    <input type="hidden" name="kelas_id" value="{{ $kelasTerpilih->id }}">
                                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th>Nama Siswa</th>
                                                    <th style="width: 45%;">Status Kehadiran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($siswas as $siswa)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $siswa->nama }}</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="kehadiran[{{ $siswa->id }}]" id="hadir_{{ $siswa->id }}" value="hadir" checked>
                                                                <label class="form-check-label" for="hadir_{{ $siswa->id }}">Hadir</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="kehadiran[{{ $siswa->id }}]" id="izin_{{ $siswa->id }}" value="izin">
                                                                <label class="form-check-label" for="izin_{{ $siswa->id }}">Izin</label>
                                                            </div>
                                                             <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="kehadiran[{{ $siswa->id }}]" id="sakit_{{ $siswa->id }}" value="sakit">
                                                                <label class="form-check-label" for="sakit_{{ $siswa->id }}">Sakit</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="kehadiran[{{ $siswa->id }}]" id="alpha_{{ $siswa->id }}" value="tidak_hadir">
                                                                <label class="form-check-label" for="alpha_{{ $siswa->id }}">Alpha</label>
                                                            </div>
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

                                    <a href="{{ route('absensi_siswa.index') }}" class="btn btn-secondary mt-3">Batal</a>
                                    <button type="submit" class="btn btn-primary mt-3" {{ $siswas->isEmpty() ? 'disabled' : '' }}>Simpan Absensi</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

