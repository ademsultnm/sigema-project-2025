@extends('backend.layouts.app')
@section('title', 'Detail Siswa')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Detail Data Siswa</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Diri Siswa</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>NIS (Nomor Induk Siswa)</label>
                                <p class="form-control-static"><strong>{{ $siswa->nis }}</strong></p>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <p class="form-control-static">{{ $siswa->nama }}</p>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <p class="form-control-static">{{ $siswa->jenis_kelamin }}</p>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</p>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <p class="form-control-static">{{ $siswa->alamat }}</p>
                            </div>
                             <div class="form-group">
                                <label>Jenjang</label>
                                <p class="form-control-static">{{ $siswa->jenjang }}</p>
                            </div>
                            <div class="form-group">
                                <label>Kelas Saat Ini</label>
                                @php
                                    $kelasSiswaSaatIni = $siswa->kelas->last();
                                @endphp
                                @if($kelasSiswaSaatIni)
                                    <p class="form-control-static">{{ $kelasSiswaSaatIni->nama }} (Tahun Ajaran: {{ $kelasSiswaSaatIni->pivot->tahun_ajaran }})</p>
                                @else
                                    <p class="form-control-static text-muted">Belum ditempatkan di kelas manapun.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Akun Login</h4>
                        </div>
                        <div class="card-body">
                            @if ($siswa->user)
                                <div class="form-group">
                                    <label>Alamat Email</label>
                                    <p class="form-control-static">{{ $siswa->user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                     <p class="form-control-static"><span class="badge bg-light-success">{{ $siswa->user->role }}</span></p>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Akun untuk siswa ini belum dibuat. Hanya Super Admin yang bisa membuatkan akun melalui menu 'Edit'.
                                </div>
                            @endif
                        </div>
                         <div class="card-footer">
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

