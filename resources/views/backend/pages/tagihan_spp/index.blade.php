@extends('backend.layouts.app')
@section('title', 'Tagihan SPP')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        @if (strtolower(auth()->user()->role) === 'murid')
            {{-- ================= TAMPILAN MURID ================= --}}
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
                                    {{-- Cek $apiKey (Variable ini hanya dikirim jika role murid) --}}
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
                                                        @if($tagihan->status == 'Belum Lunas')
                                                            <a href="{{ route('pay.create', $tagihan->id) }}" class="btn btn-primary btn-sm">
                                                                Bayar Sekarang
                                                            </a>
                                                        @elseif($tagihan->status == 'Lunas')
                                                            <i class="bi bi-check-circle-fill text-success"></i>
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
        {{-- ================= TAMPILAN ADMIN & STAF ================= --}}
        <div class="page-heading">
            <h3>Kelola Tagihan SPP</h3>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <h5 class="m-0">Daftar Tagihan</h5>
                                </div>

                                {{-- FORM FILTER KELAS --}}
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <form action="{{ route('tagihan-spp.index') }}" method="GET">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-filter"></i> Filter Kelas</span>
                                            <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                                                <option value="">-- Semua Kelas --</option>
                                                @foreach ($kelasList as $kelas)
                                                    {{-- PERBAIKAN: Menggunakan $kelas->nama sesuai DB --}}
                                                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                                        {{ $kelas->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-3 text-md-end">
                                    <a href="{{ route('tagihan-spp.create') }}" class="btn btn-primary w-100">
                                        <i class="bi bi-plus-circle"></i> Buat Tagihan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th> {{-- Kolom Kelas --}}
                                            <th>Periode</th>
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
                                                <td>
                                                    <span class="fw-bold">{{ $tagihan->siswa->nama ?? 'Siswa Dihapus' }}</span>
                                                </td>

                                                {{-- LOGIKA PINTAR: Menampilkan Kelas sesuai Tahun Ajaran Tagihan --}}
                                                <td>
                                                    @php
                                                        $kelasSiswa = null;
                                                        if ($tagihan->siswa) {
                                                            // Coba cari kelas yang tahun ajarannya sama dengan tagihan
                                                            $kelasSiswa = $tagihan->siswa->kelas->where('pivot.tahun_ajaran', $tagihan->tahun_ajaran)->first();

                                                            // Jika tidak ketemu, ambil kelas terakhir (latest)
                                                            if (!$kelasSiswa) {
                                                                $kelasSiswa = $tagihan->siswa->kelas->last();
                                                            }
                                                        }
                                                    @endphp

                                                    @if($kelasSiswa)
                                                        {{-- PERBAIKAN: Menggunakan ->nama sesuai DB --}}
                                                        <span class="badge bg-light-primary text-primary">{{ $kelasSiswa->nama }}</span>
                                                    @else
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </td>

                                                <td>{{ $tagihan->tahun_ajaran }}</td>
                                                <td>{{ $tagihan->deskripsi }}</td>
                                                <td>Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($tagihan->status == 'Lunas')
                                                        <span class="badge bg-light-success text-success">Lunas</span>
                                                    @else
                                                        <span class="badge bg-light-danger text-danger">Belum Lunas</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('tagihan-spp.show', $tagihan->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                                        <a href="{{ route('tagihan-spp.edit', $tagihan->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                                        <form action="{{ route('tagihan-spp.destroy', $tagihan->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus tagihan ini?')" title="Hapus"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <img src="{{ asset('assets/images/samples/error-404.png') }}" alt="No Data" style="height: 100px; opacity: 0.5">
                                                        <p class="mt-2 text-muted">Belum ada data tagihan.</p>
                                                    </td>
                                                </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination dengan mempertahankan filter --}}
                            <div class="mt-4">
                                {{ $tagihanSpps->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

