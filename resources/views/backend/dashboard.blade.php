@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        {{-- ========================================================== --}}
        {{--                    TAMPILAN DASHBOARD SISWA                --}}
        {{-- ========================================================== --}}
        @if (isset($user_role) && $user_role === 'siswa')
            <div class="page-heading">
                <h3>Halo, {{ $user_name }}! 👋</h3>
                <p class="text-subtitle text-muted">Berikut adalah ringkasan performa akademik Anda.</p>
            </div>

            <div class="page-content">
                <div class="row">
                    @if(isset($nilaiPerMapel) && count($nilaiPerMapel) > 0)
                        @foreach ($nilaiPerMapel as $data)
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                                {{-- Link ke Detail Nilai (Layer 2) --}}
                                <a href="{{ route('dashboard.nilai.detail', $data['mapel_id']) }}" class="text-decoration-none">
                                    <div class="card h-100 shadow-sm border-0 transition-hover">
                                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                                            {{-- Ikon Buku/Mapel --}}
                                            <div class="avatar avatar-xl bg-light-primary mb-3">
                                                <i class="bi bi-journal-bookmark-fill fs-1 text-primary"></i>
                                            </div>
                                            
                                            {{-- Nama Mapel --}}
                                            <h5 class="font-bold mb-1 text-dark">{{ $data['mapel_nama'] }}</h5>
                                            <p class="text-muted small mb-3">{{ $data['jumlah_data'] }} Data Nilai</p>
                                            
                                            {{-- Nilai Rata-rata Besar --}}
                                            {{-- Logika Warna: Hijau (>=85), Kuning (75-84), Merah (<75) --}}
                                            <div class="mb-3">
                                                <h1 class="font-extrabold mb-0 
                                                    {{ $data['rata_rata_total'] >= 85 ? 'text-success' : ($data['rata_rata_total'] >= 75 ? 'text-warning' : 'text-danger') }}" 
                                                    style="font-size: 3.5rem;">
                                                    {{ $data['rata_rata_total'] }}
                                                </h1>
                                                <span class="badge bg-light-secondary text-secondary">Rata-rata</span>
                                            </div>
                                            
                                            <div class="w-100 mt-auto">
                                                <button class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                                                    Lihat Rincian <i class="bi bi-arrow-right ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-light-warning color-warning">
                                <i class="bi bi-exclamation-circle"></i> Belum ada data nilai raport yang tersedia untuk Anda saat ini.
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CSS Tambahan khusus halaman ini --}}
            <style>
                .transition-hover {
                    transition: all 0.3s ease;
                }
                .transition-hover:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0,0,0,.1) !important;
                }
            </style>

        {{-- ========================================================== --}}
        {{--                TAMPILAN DASHBOARD ADMIN / GURU             --}}
        {{-- ========================================================== --}}
        @else
            <div class="page-heading">
                <h3>Statistik Sekolah</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        {{-- Baris Statistik Utama --}}
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon blue mb-2"><i class="iconly-boldProfile"></i></div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Total Siswa</h6>
                                                <h6 class="font-extrabold mb-0">{{ $jumlahSiswa ?? 0 }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon green mb-2"><i class="iconly-boldAdd-User"></i></div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Total Guru</h6>
                                                <h6 class="font-extrabold mb-0">{{ $jumlahGuru ?? 0 }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon red mb-2"><i class="iconly-boldBookmark"></i></div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Total Kelas</h6>
                                                <h6 class="font-extrabold mb-0">{{ $jumlahKelas ?? 0 }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon purple mb-2"><i class="iconly-boldShow"></i></div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Mata Pelajaran</h6>
                                                <h6 class="font-extrabold mb-0">{{ $jumlahMapel ?? 0 }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Grafik & Tabel --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Pertumbuhan Siswa Baru (1 Tahun Terakhir)</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-profile-visit"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Siswa Terbaru Ditambahkan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-lg">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Jenjang</th>
                                                        <th>Tanggal Masuk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($siswaTerbaru ?? [] as $siswa)
                                                        <tr>
                                                            <td class="col-auto">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-md">
                                                                        <img src="{{ asset('backend/assets/compiled/jpg/2.jpg') }}" alt="Avatar">
                                                                    </div>
                                                                    <p class="font-bold mb-0 ms-3">{{ $siswa->nama }}</p>
                                                                </div>
                                                            </td>
                                                            <td class="col-auto">
                                                                <span class="badge {{ $siswa->jenjang == 'SMA' ? 'bg-success' : 'bg-primary' }}">{{ $siswa->jenjang }}</span>
                                                            </td>
                                                            <td class="col-auto">
                                                                <p class="mb-0 small">{{ $siswa->created_at->format('d M Y') }}</p>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center">Belum ada data siswa baru.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Kanan (Profil & Guru) --}}
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="{{ asset('backend/assets/compiled/jpg/1.jpg') }}" alt="Face 1">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold">{{ $user_name }}</h5>
                                        <h6 class="text-muted mb-0">{{ $user_role }}</h6>
                                    </div>
                                </div>
                                <form id="logout-form" action="{{ route('logouts') }}" method="POST" class="mt-3 w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Grafik Donat --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Komposisi Siswa</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-visitors-profile"></div>
                            </div>
                        </div>

                        {{-- Guru Terbaru --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Guru Terbaru</h4>
                            </div>
                            <div class="card-content pb-4">
                                @forelse ($guruTerbaru ?? [] as $guru)
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            <img src="{{ asset('backend/assets/compiled/jpg/4.jpg') }}">
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1">{{ $guru->nama }}</h5>
                                            <h6 class="text-muted mb-0 small">{{ $guru->mata_pelajaran }}</h6>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4">
                                        <p class="text-center text-muted">Belum ada data guru baru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Script Chart (Hanya Load jika bukan siswa) --}}
            @push('scripts')
            <script src="{{ asset('backend/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Data dari Controller
                const siswaSMP = {{ $siswaSMP ?? 0 }};
                const siswaSMA = {{ $siswaSMA ?? 0 }};
                const chartLabels = {!! $chartLabels ?? '[]' !!};
                const chartData = {!! $chartData ?? '[]' !!};

                // Grafik Garis: Pertumbuhan Siswa
                var optionsProfileVisit = {
                    annotations: { position: 'back' },
                    dataLabels: { enabled: false },
                    chart: { type: 'bar', height: 300 },
                    fill: { opacity: 1 },
                    plotOptions: {},
                    series: [{ name: 'Siswa Baru', data: chartData }],
                    colors: '#435ebe',
                    xaxis: { categories: chartLabels },
                };

                if(document.querySelector("#chart-profile-visit")) {
                    var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
                    chartProfileVisit.render();
                }

                // Grafik Donat: Komposisi Siswa
                var optionsVisitorsProfile = {
                    series: [siswaSMP, siswaSMA],
                    labels: ['SMP', 'SMA'],
                    colors: ['#435ebe','#55c6e8'],
                    chart: { type: 'donut', width: '100%', height: '350px' },
                    legend: { position: 'bottom' },
                    plotOptions: { pie: { donut: { size: '30%' } } }
                };

                if(document.getElementById('chart-visitors-profile')) {
                    var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile);
                    chartVisitorsProfile.render();
                }
            });
            </script>
            @endpush
        @endif
    </div>
@endsection