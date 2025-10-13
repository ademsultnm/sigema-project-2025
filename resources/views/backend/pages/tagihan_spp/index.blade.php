@extends('backend.layouts.app')
@section('title', 'Tagihan SPP')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>
        
        @if (strtolower(auth()->user()->role) === 'murid')
            {{-- ---------------- TAMPILAN UNTUK SISWA ---------------- --}}
             <div class="page-heading">
                <h3>Tagihan SPP Saya</h3>
            </div>
             <div class="page-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Daftar Tagihan</div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                                @endif
                                 @if (empty($apiKey))
                                    <div class="alert alert-light-warning color-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Sistem pembayaran online sedang tidak aktif. Silakan hubungi admin.
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                                <th>Jatuh Tempo</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tagihanSpps as $tagihan)
                                                <tr>
                                                    <td>{{ $tagihan->deskripsi }}</td>
                                                    <td>Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d F Y') }}</td>
                                                    <td>
                                                        @if($tagihan->status == 'Lunas')
                                                            <span class="badge bg-success">Lunas</span>
                                                        @else
                                                            <span class="badge bg-danger">Belum Lunas</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($tagihan->status == 'Belum Lunas' && !empty($apiKey))
                                                            {{-- Tombol ini akan mengarah ke API Paydisini --}}
                                                            <a href="#" class="btn btn-primary btn-sm" onclick="alert('Fitur pembayaran akan diintegrasikan dengan API Paydisini.')">Bayar Sekarang</a>
                                                        @elseif($tagihan->status == 'Lunas')
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada tagihan untuk Anda.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                 {{ $tagihanSpps->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
             {{-- ---------------- TAMPILAN UNTUK ADMIN & STAF ---------------- --}}
            <div class="page-heading">
                <h3>Kelola Tagihan SPP</h3>
            </div>
             <div class="page-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Daftar Tagihan</h5>
                                <a href="{{ route('tagihan-spp.create') }}" class="btn btn-primary">Buat Tagihan Baru</a>
                            </div>

                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Siswa</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tagihanSpps as $tagihan)
                                                <tr>
                                                    <td>{{ $loop->iteration + $tagihanSpps->firstItem() - 1 }}</td>
                                                    <td>{{ $tagihan->siswa->nama ?? 'Siswa Dihapus' }}</td>
                                                    <td>{{ $tagihan->deskripsi }}</td>
                                                    <td>Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($tagihan->status == 'Lunas')
                                                            <span class="badge bg-light-success">Lunas</span>
                                                        @else
                                                            <span class="badge bg-light-danger">Belum Lunas</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tagihan-spp.show', $tagihan->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                        <a href="{{ route('tagihan-spp.edit', $tagihan->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                        <form action="{{ route('tagihan-spp.destroy', $tagihan->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data tagihan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                 {{ $tagihanSpps->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

