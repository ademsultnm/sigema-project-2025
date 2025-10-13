<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/logo2.png') }}" alt="Logo" style="height: 70px; width: auto;"></a>
                </div>

                {{-- Theme Toggle --}}
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                </path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Utama</li>

                <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }} ">
                    <a href="{{ route('home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- ========================================================== --}}
                {{--                      MENU SUPER ADMIN                      --}}
                {{-- ========================================================== --}}
                @if (strtolower(auth()->user()->role) === 'super admin')
                    <li class="sidebar-title">Super Admin Menu</li>
                    {{-- KELOLA PENGGUNA --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['siswa.*', 'guru.*', 'admin.*', 'staf.*', 'waka.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-people-fill"></i><span>Kelola Pengguna</span></a>
                        <ul class="submenu {{ request()->routeIs(['siswa.*', 'guru.*', 'admin.*', 'staf.*', 'waka.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('siswa.*') ? 'active' : '' }} "><a href="{{ route('siswa.index') }}" class="submenu-link">Siswa</a></li>
                            <li class="submenu-item {{ request()->routeIs('guru.*') ? 'active' : '' }} "><a href="{{ route('guru.index') }}" class="submenu-link">Guru</a></li>
                            <li class="submenu-item {{ request()->routeIs('admin.*') ? 'active' : '' }} "><a href="{{ route('admin.index') }}" class="submenu-link">Admin</a></li>
                            <li class="submenu-item {{ request()->routeIs('staf.*') ? 'active' : '' }} "><a href="{{ route('staf.index') }}" class="submenu-link">Staf Keuangan</a></li>
                            <li class="submenu-item {{ request()->routeIs('waka.*') ? 'active' : '' }} "><a href="{{ route('waka.index') }}" class="submenu-link">Waka Kurikulum</a></li>
                        </ul>
                    </li>
                    
                    {{-- DATA MASTER AKADEMIK --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['jenjang.*', 'jurusan.*', 'mapel.*', 'kelas_admin.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-stack"></i><span>Data Master</span></a>
                        <ul class="submenu {{ request()->routeIs(['jenjang.*', 'jurusan.*', 'mapel.*', 'kelas_admin.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('jenjang.*') ? 'active' : '' }} "><a href="{{route('jenjang.index')}}" class="submenu-link">Jenjang</a></li>
                            <li class="submenu-item {{ request()->routeIs('jurusan.*') ? 'active' : '' }} "><a href="{{route('jurusan.index')}}" class="submenu-link">Jurusan</a></li>
                            <li class="submenu-item {{ request()->routeIs('mapel.*') ? 'active' : '' }} "><a href="{{route('mapel.index')}}" class="submenu-link">Mata Pelajaran</a></li>
                            <li class="submenu-item {{ request()->routeIs('kelas_admin.*') ? 'active' : '' }} "><a href="{{route('kelas_admin.index')}}" class="submenu-link">Kelas</a></li>
                        </ul>
                    </li>
                    
                    {{-- KEUANGAN --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['tagihan-spp.*', 'laporan-keuangan.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-wallet-fill"></i><span>Keuangan</span></a>
                        <ul class="submenu {{ request()->routeIs(['tagihan-spp.*', 'laporan-keuangan.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('tagihan-spp.*') ? 'active' : '' }}"><a href="{{ route('tagihan-spp.index') }}" class="submenu-link">Tagihan SPP</a></li>
                            <li class="submenu-item {{ request()->routeIs('laporan-keuangan.*') ? 'active' : '' }}"><a href="{{ route('laporan-keuangan.index') }}" class="submenu-link">Laporan Keuangan</a></li>
                        </ul>
                    </li>
                    
                    {{-- PEMBELAJARAN & PENILAIAN --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['e_learning.*', 'jawaban-siswa.*', 'nilai.*', 'raports.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-journal-bookmark-fill"></i><span>Pembelajaran</span></a>
                         <ul class="submenu {{ request()->routeIs(['e_learning.*', 'jawaban-siswa.*', 'nilai.*', 'raports.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('e_learning.*') ? 'active' : '' }} "><a href="{{route('e_learning.index')}}" class="submenu-link">Kelola Materi & Tugas</a></li>
                             <li class="submenu-item {{ request()->routeIs('jawaban-siswa.*') ? 'active' : '' }}"><a href="{{ route('jawaban-siswa.index') }}" class="submenu-link">Jawaban Siswa</a></li>
                            <li class="submenu-item {{ request()->routeIs('nilai.*') ? 'active' : '' }} "><a href="{{route('nilai.index')}}" class="submenu-link">Nilai</a></li>
                            <li class="submenu-item {{ request()->routeIs('raports.*') ? 'active' : '' }} "><a href="{{route('raports.index')}}" class="submenu-link">Raport</a></li>
                        </ul>
                    </li>

                    {{-- ABSENSI --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['absensi-guru.*', 'absensi_siswa.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-person-check-fill"></i><span>Absensi</span></a>
                        <ul class="submenu {{ request()->routeIs(['absensi-guru.*', 'absensi_siswa.*']) ? 'active' : '' }}">
                             <li class="submenu-item {{ request()->routeIs('absensi-guru.index') ? 'active' : '' }} "><a href="{{route('absensi-guru.index')}}" class="submenu-link">Absensi Guru</a></li>
                            <li class="submenu-item {{ request()->routeIs('absensi_siswa.index') ? 'active' : '' }} "><a href="{{route('absensi_siswa.index')}}" class="submenu-link">Absensi Siswa</a></li>
                        </ul>
                    </li>

                {{-- ========================================================== --}}
                {{--                        MENU ADMIN BIASA                    --}}
                {{-- ========================================================== --}}
                @elseif (strtolower(auth()->user()->role) === 'admin')
                     <li class="sidebar-title">Admin Menu</li>
                    {{-- INPUT DATA OPERASIONAL --}}
                     <li class="sidebar-item has-sub {{ request()->routeIs(['siswa.*', 'guru.*', 'kelas_admin.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-pencil-square"></i><span>Input Data</span></a>
                        <ul class="submenu {{ request()->routeIs(['siswa.*', 'guru.*', 'kelas_admin.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('siswa.*') ? 'active' : '' }} "><a href="{{ route('siswa.index') }}" class="submenu-link">Input Siswa</a></li>
                            <li class="submenu-item {{ request()->routeIs('guru.*') ? 'active' : '' }} "><a href="{{ route('guru.index') }}" class="submenu-link">Input Guru</a></li>
                            <li class="submenu-item {{ request()->routeIs('kelas_admin.*') ? 'active' : '' }} "><a href="{{route('kelas_admin.index')}}" class="submenu-link">Input Kelas</a></li>
                        </ul>
                    </li>
                     {{-- PEMBELAJARAN (TERBATAS) --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['e_learning.*', 'jawaban-siswa.*', 'nilai.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-journal-bookmark-fill"></i><span>Akademik</span></a>
                        <ul class="submenu {{ request()->routeIs(['e_learning.*', 'jawaban-siswa.*', 'nilai.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('e_learning.*') ? 'active' : '' }} "><a href="{{route('e_learning.index')}}" class="submenu-link">Tugas & Materi</a></li>
                             <li class="submenu-item {{ request()->routeIs('jawaban-siswa.*') ? 'active' : '' }}"><a href="{{ route('jawaban-siswa.index') }}" class="submenu-link">Jawaban Siswa</a></li>
                            <li class="submenu-item {{ request()->routeIs('nilai.*') ? 'active' : '' }} "><a href="{{route('nilai.index')}}" class="submenu-link">Nilai Siswa</a></li>
                        </ul>
                    </li>
                    
                    {{-- KEUANGAN --}}
                    <li class="sidebar-item has-sub {{ request()->routeIs(['tagihan-spp.*', 'laporan-keuangan.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-wallet-fill"></i><span>Keuangan</span></a>
                        <ul class="submenu {{ request()->routeIs(['tagihan-spp.*', 'laporan-keuangan.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('tagihan-spp.*') ? 'active' : '' }}"><a href="{{ route('tagihan-spp.index') }}" class="submenu-link">Input Tagihan SPP</a></li>
                            <li class="submenu-item {{ request()->routeIs('laporan-keuangan.*') ? 'active' : '' }}"><a href="{{ route('laporan-keuangan.index') }}" class="submenu-link">Laporan Keuangan</a></li>
                        </ul>
                    </li>
                
                {{-- ========================================================== --}}
                {{--                          MENU GURU                         --}}
                {{-- ========================================================== --}}
                @elseif (strtolower(auth()->user()->role) === 'guru')
                    <li class="sidebar-title">Menu Guru</li>
                    <li class="sidebar-item has-sub {{ request()->routeIs(['e_learning.*', 'jawaban-siswa.*', 'nilai.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-journal-bookmark-fill"></i><span>Pembelajaran</span></a>
                        <ul class="submenu {{ request()->routeIs(['e_learning.*', 'jawaban-siswa.*', 'nilai.*']) ? 'active' : '' }}">
                             <li class="submenu-item {{ request()->routeIs('e_learning.*') ? 'active' : '' }}"><a href="{{ route('e_learning.index') }}" class="submenu-link">Kelola Materi & Tugas</a></li>
                             <li class="submenu-item {{ request()->routeIs('jawaban-siswa.*') ? 'active' : '' }}"><a href="{{ route('jawaban-siswa.index') }}" class="submenu-link">Jawaban Siswa</a></li>
                             <li class="submenu-item {{ request()->routeIs('nilai.*') ? 'active' : '' }}"><a href="{{ route('nilai.index') }}" class="submenu-link">Input Nilai</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('absensi_siswa.*') ? 'active' : '' }}">
                        <a href="{{ route('absensi_siswa.index') }}" class='sidebar-link'><i class="bi bi-person-check-fill"></i><span>Absensi Siswa</span></a>
                    </li>
                     <li class="sidebar-item {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                        <a href="{{ route('siswa.index') }}" class='sidebar-link'><i class="bi bi-people-fill"></i><span>Data Siswa</span></a>
                    </li>
                
                {{-- ========================================================== --}}
                {{--                          MENU SISWA                        --}}
                {{-- ========================================================== --}}
                @elseif (strtolower(auth()->user()->role) === 'murid')
                    <li class="sidebar-title">Menu Siswa</li>
                    <li class="sidebar-item {{ request()->routeIs('siswa.elearning.*') ? 'active' : '' }}">
                        <a href="{{ route('siswa.elearning.index') }}" class='sidebar-link'><i class="bi bi-book-fill"></i><span>Materi & Tugas</span></a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('nilai.index') ? 'active' : '' }}">
                        <a href="{{ route('nilai.index') }}" class='sidebar-link'><i class="bi bi-card-checklist"></i><span>Lihat Nilai</span></a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('tagihan-spp.index') ? 'active' : '' }}">
                        <a href="{{ route('tagihan-spp.index') }}" class='sidebar-link'><i class="bi bi-wallet-fill"></i><span>Pembayaran SPP</span></a>
                    </li>
                     <li class="sidebar-item {{ request()->routeIs('absensi_siswa.index') ? 'active' : '' }}">
                        <a href="{{ route('absensi_siswa.index') }}" class='sidebar-link'><i class="bi bi-person-check-fill"></i><span>Absensi Saya</span></a>
                    </li>

                {{-- ========================================================== --}}
                {{--                      MENU STAF KEUANGAN                    --}}
                {{-- ========================================================== --}}
                @elseif (in_array(strtolower(auth()->user()->role), ['staf keuangan', 'staf']))
                    <li class="sidebar-title">Menu Keuangan</li>
                    <li class="sidebar-item has-sub {{ request()->routeIs(['tagihan-spp.*', 'laporan-keuangan.*']) ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'><i class="bi bi-wallet-fill"></i><span>Keuangan</span></a>
                        <ul class="submenu {{ request()->routeIs(['tagihan-spp.*', 'laporan-keuangan.*']) ? 'active' : '' }}">
                            <li class="submenu-item {{ request()->routeIs('tagihan-spp.*') ? 'active' : '' }}"><a href="{{ route('tagihan-spp.index') }}" class="submenu-link">Verifikasi Pembayaran</a></li>
                            <li class="submenu-item {{ request()->routeIs('laporan-keuangan.*') ? 'active' : '' }}"><a href="{{ route('laporan-keuangan.index') }}" class="submenu-link">Laporan Keuangan SPP</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                        <a href="{{ route('siswa.index') }}" class='sidebar-link'><i class="bi bi-people-fill"></i><span>Data Siswa</span></a>
                    </li>

                {{-- ========================================================== --}}
                {{--                   MENU WAKA KURIKULUM                    --}}
                {{-- ========================================================== --}}
                @elseif (strtolower(auth()->user()->role) == 'waka kurikulum')
                    <li class="sidebar-title">Menu Kurikulum</li>
                    <li class="sidebar-item {{ request()->routeIs('jadwal-pelajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('jadwal-pelajaran.index') }}" class='sidebar-link'><i class="bi bi-calendar-week-fill"></i><span>Kelola Jadwal</span></a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
                        <a href="{{ route('mapel.index') }}" class='sidebar-link'><i class="bi bi-journal-album"></i><span>Kelola Mata Pelajaran</span></a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('kelas_admin.*') ? 'active' : '' }}">
                        <a href="{{ route('kelas_admin.index') }}" class='sidebar-link'><i class="bi bi-house-door-fill"></i><span>Kelola Kelas</span></a>
                    </li>
                 @endif
                
                 {{-- Tombol Logout --}}
                <li class="sidebar-title">Akun</li>
                <li class="sidebar-item">
                    <a href="{{ route('logouts') }}" class='sidebar-link' 
                        onclick="event.preventDefault(); 
                                 if(confirm('Apakah Anda yakin ingin keluar?')) {
                                     document.getElementById('logout-form').submit();
                                 }">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logouts') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

