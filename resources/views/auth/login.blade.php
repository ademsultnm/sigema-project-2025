@extends('layouts.app')

@section('title')
Login
@endsection

@section('content')
    <div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card">
                <div class="card-body">


                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo " width="150">

                    </div>

                    <h3 class="text-center login-card-title">Selamat Datang Kembali</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Input Email dengan Ikon --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Alamat Email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password dengan Ikon --}}
                        <div class="mb-3">
                                <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label auth-links" for="remember">
                                    {{ __('Ingat Saya') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link auth-links p-0" href="{{ route('password.request') }}">
                                    {{ __('Lupa Password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-login">
                                {{ __('Login') }}
                            </button>
                        </div>

                        {{-- Daftar Akun / register --}}
                        {{-- @if (Route::has('register'))
                        <p class="text-center auth-links">
                            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                        </p>
                        @endif --}}

                        @if (Route::has('register'))
                            <p class="text-center auth-links">
                                Belum punya akun? <b>Silahkan Ke Ruang TU.</b>
                            </p>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection