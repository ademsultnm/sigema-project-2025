@extends('backend.layouts.app')
@section('title', 'Pengaturan Aplikasi')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Pengaturan Aplikasi</h3>
            <p class="text-subtitle text-muted">Kelola konfigurasi dan integrasi pihak ketiga di sini.</p>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Pengaturan Payment Gateway</h5>
                        </div>
                        <div class="card-body">
                             @if (session('success'))
                                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('settings.update') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="paydisini_api_key">API Key Paydisini</label>
                                    <input type="text" id="paydisini_api_key" class="form-control" name="paydisini_api_key" value="{{ $apiKey }}" placeholder="Masukkan API Key Anda">
                                    <small class="form-text text-muted">API Key ini akan digunakan untuk memproses pembayaran SPP online.</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
