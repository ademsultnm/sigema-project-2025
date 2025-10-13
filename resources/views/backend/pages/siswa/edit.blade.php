@extends('backend.layouts.app')
@section('title', 'Edit Siswa')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>
        <div class="page-heading">
            <h3>Edit Data Siswa</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h5>Form Edit Siswa</h5></div>
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

                            <form method="POST" action="{{ route('siswa.update', $siswa->id) }}">
                                @csrf
                                @method('PUT')
                                <h6>Data Diri Siswa</h6>
                                 <div class="form-group">
                                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                                    <input type="text" id="nis" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
                                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $siswa->nama) }}" required>
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                 <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenjang">Jenjang</label>
                                    <select id="jenjang" class="form-control @error('jenjang') is-invalid @enderror" name="jenjang" required>
                                        <option value="SMP" {{ old('jenjang', $siswa->jenjang) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('jenjang', $siswa->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    </select>
                                    @error('jenjang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <hr>
                                <h6>Penempatan Kelas</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kelas_id">Kelas</label>
                                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @php
                                                    $kelasSiswaSaatIni = $siswa->kelas->last();
                                                @endphp
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ ($kelasSiswaSaatIni && $kelasSiswaSaatIni->id == $k->id) ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran</label>
                                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $kelasSiswaSaatIni->pivot->tahun_ajaran ?? now()->year . '/' . (now()->year + 1)) }}" required>
                                        </div>
                                    </div>
                                </div>

                                @if(strtolower(auth()->user()->role) === 'super admin')
                                    <hr>
                                    <h6>Akun Login Siswa</h6>
                                     @if(!$siswa->user)
                                        <div class="alert alert-light-warning color-warning">
                                            <i class="bi bi-exclamation-triangle"></i> Siswa ini belum memiliki akun. Isi form di bawah untuk membuatkannya. Password <strong>wajib</strong> diisi.
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="email">Alamat Email</label>
                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $siswa->user->email ?? '') }}" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password Baru</label>
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                                    </div>
                                @endif

                                <a href="{{ route('siswa.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

