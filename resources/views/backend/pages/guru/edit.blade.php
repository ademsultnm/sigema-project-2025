@extends('backend.layouts.app')
@section('title', 'Edit Guru')
@section('content')
 <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>
        <div class="page-heading">
            <h3>Edit Data Guru</h3>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h5>Form Edit Guru</h5></div>
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
                            
                            <form method="POST" action="{{ route('guru.update', $guru->id) }}">
                                @csrf
                                @method('PUT')
                                
                                <h6>Biodata Guru</h6>
                                <div class="form-group">
                                    <label for="nama">Nama Guru</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $guru->nama) }}" required>
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                 <div class="form-group">
                                    <label for="mata_pelajaran">Mata Pelajaran</label>
                                    <input type="text" class="form-control @error('mata_pelajaran') is-invalid @enderror" id="mata_pelajaran" name="mata_pelajaran" value="{{ old('mata_pelajaran', $guru->mata_pelajaran) }}" required>
                                    @error('mata_pelajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenjang">Jenjang</label>
                                    <select class="form-control" id="jenjang" name="jenjang" required>
                                        <option value="SMP" @if ($guru->jenjang === 'SMP') selected @endif>SMP</option>
                                        <option value="SMA" @if ($guru->jenjang === 'SMA') selected @endif>SMA</option>
                                    </select>
                                </div>

                                {{-- =============================================== --}}
                                {{--        TAMPILKAN HANYA UNTUK SUPER ADMIN        --}}
                                {{-- =============================================== --}}
                                @if(strtolower(auth()->user()->role) === 'super admin')
                                    <hr>
                                    <h6>Akun Login</h6>
                                     @if(!$guru->user)
                                        <div class="alert alert-light-warning color-warning">
                                            <i class="bi bi-exclamation-triangle"></i> Guru ini belum memiliki akun. Isi form di bawah untuk membuatkannya. Password <strong>wajib</strong> diisi.
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $guru->user->email ?? '') }}" required>
                                         @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
    
                                    <div class="form-group">
                                        <label for="password">Password Baru (Opsional)</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
    
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                                <a href="{{ route('guru.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

