@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Statistik Sekolah</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        {{-- Card Jumlah Siswa --}}
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Siswa</h6>
                                            <h6 class="font-extrabold mb-0">{{ $jumlahSiswa }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Card Jumlah Guru --}}
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon green mb-2">
                                                <i class="iconly-boldAdd-User"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Guru</h6>
                                            <h6 class="font-extrabold mb-0">{{ $jumlahGuru }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Card Jumlah Kelas --}}
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon red mb-2">
                                                <i class="iconly-boldBookmark"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Kelas</h6>
                                            <h6 class="font-extrabold mb-0">{{ $jumlahKelas }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Card Jumlah Mata Pelajaran --}}
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Mata Pelajaran</h6>
                                            <h6 class="font-extrabold mb-0">{{ $jumlahMapel }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   

                    <div class="row">
                        <div class="col-12 col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Siswa Per Jenjang</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-7">
                                            <div class="d-flex align-items-center">
                                                <svg class="bi text-primary" width="10" height="10" fill="currentColor">
                                                    <use xlink:href="{{ asset('backend/assets/static/images/bootstrap-icons.svg#circle-fill') }}" />
                                                </svg>
                                                <h5 class="mb-0 ms-3">SMP</h5>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <h5 class="mb-0 text-end">{{ $siswaSMP }}</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="d-flex align-items-center">
                                                <svg class="bi text-success" width="10" height="10" fill="currentColor">
                                                    <use xlink:href="{{ asset('backend/assets/static/images/bootstrap-icons.svg#circle-fill') }}" />
                                                </svg>
                                                <h5 class="mb-0 ms-3">SMA</h5>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <h5 class="mb-0 text-end">{{ $siswaSMA }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Siswa Terbaru</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-lg">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Jenjang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($siswaTerbaru as $siswa)
                                                <tr>
                                                    <td class="col-auto"><p class="font-bold mb-0">{{ $siswa->nama }}</p></td>
                                                    <td class="col-auto"><p class="mb-0">{{ $siswa->jenjang }}</p></td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="2" class="text-center">Belum ada data siswa baru.</td>
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
                            {{-- Tombol Logout dengan Konfirmasi --}}
                            <a href="{{ route('logouts') }}" class="btn btn-danger mt-3 w-100"
                               onclick="event.preventDefault(); 
                                        if(confirm('Apakah Anda yakin ingin keluar?')) {
                                            window.location.href='{{ route('logouts') }}';
                                        }">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Guru Terbaru</h4>
                        </div>
                        <div class="card-content pb-4">
                            @forelse ($guruTerbaru as $guru)
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="{{ asset('backend/assets/compiled/jpg/4.jpg') }}">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">{{ $guru->nama }}</h5>
                                    <h6 class="text-muted mb-0">{{ $guru->mata_pelajaran }}</h6>
                                </div>
                            </div>
                            @empty
                            <div class="px-4">
                                <p class="text-center">Belum ada data guru baru.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Komposisi Siswa</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-visitors-profile"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Pastikan Anda sudah memuat ApexCharts di layout utama Anda --}}
{{-- Contoh: <script src="{{ asset('backend/assets/extensions/apexcharts/apexcharts.min.js') }}"></script> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Data dari Controller
    const siswaSMP = {{ $siswaSMP }};
    const siswaSMA = {{ $siswaSMA }};
    const chartLabels = {!! $chartLabels !!};
    const chartData = {!! $chartData !!};

    // Grafik Garis: Pertumbuhan Siswa
    var optionsProfileVisit = {
        annotations: {
            position: 'back'
        },
        dataLabels: {
            enabled: false
        },
        chart: {
            type: 'bar',
            height: 300
        },
        fill: {
            opacity: 1
        },
        plotOptions: {},
        series: [{
            name: 'Siswa Baru',
            data: chartData
        }],
        colors: '#435ebe',
        xaxis: {
            categories: chartLabels,
        },
    };

    var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
    chartProfileVisit.render();

    // Grafik Donat: Komposisi Siswa
    var optionsVisitorsProfile = {
        series: [siswaSMP, siswaSMA],
        labels: ['SMP', 'SMA'],
        colors: ['#435ebe','#55c6e8'],
        chart: {
            type: 'donut',
            width: '100%',
            height: '350px'
        },
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '30%'
                }
            }
        }
    };

    var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile);
    chartVisitorsProfile.render();
});
</script>
@endpush

