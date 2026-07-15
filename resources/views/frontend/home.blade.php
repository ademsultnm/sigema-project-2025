@extends('frontend.layouts.app')
@section('title', 'SIGEMA - Sistem Informasi & Manajemen Akademik')
@section('content')
    <main>
        <article>

            <!-- #BANNER INTRO-->
            <section class="section category" aria-label="category">
                <div class="container-fluid banner">
                    <img src="{{ asset('images/welcome_banner.png') }}" alt="Welcome to SIGEMA" class="w-100" style="align-items: center;">
                </div>
            </section>

            <!-- #HERO-->
            <section class="hero" id="home" aria-label="hero"
                style="background-color: hsl(220, 20%, 97%);">
                <div class="container">

                    <div class="hero-content">

                        <p class="section-subtitle" style="color: var(--kappel);">Selamat Datang di SIGEMA</p>

                        <h2 class="h1 hero-title" style="color: var(--oxford-blue);">Manajemen Belajar Menjadi Lebih Mudah</h2>

                        <p class="hero-text" style="color: var(--slate-gray);">
                            Akses semua materi pelajaran, kerjakan tugas, lihat nilai, dan kelola administrasi sekolah Anda dalam satu platform terintegrasi.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <span class="span">Login Sekarang</span>
                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                        </a>
                    </div>
                    <figure class="hero-banner">

                        <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="500" height="500"
                            loading="lazy" alt="Siswa sedang belajar bersama" class="w-100">

                        <img src="{{ asset('frontend/assets/images/hero-abs-1.png') }}" width="318" height="352"
                            loading="lazy" aria-hidden="true" class="abs-img abs-img-1">

                        <img src="{{ asset('frontend/assets/images/hero-abs-2.png') }}" width="160" height="160"
                            loading="lazy" aria-hidden="true" class="abs-img abs-img-2">
                    </figure>
                </div>
            </section>

            <!-- #CATEGORY-->
            <div data-aos="fade-up" data-aos-duration="2000">
            <section class="section category" aria-label="category">
                <div class="container">
                    <p class="section-subtitle">Akses Utama</p>
                    <h2 class="h2 section-title">Jelajahi Berbagai Fitur Unggulan Kami</h2>
                    <ul class="grid-list">
                        <li>
                            <div class="category-card">
                                <div class="card-icon">
                                    <ion-icon name="book-outline"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="h3 card-title">
                                        <a>Materi & Tugas Online</a>
                                    </h3>
                                    <span class="card-meta">Akses materi & kumpulkan tugas</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="category-card">
                                <div class="card-icon">
                                    <ion-icon name="school-outline"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="h3 card-title">
                                        <a>Manajemen Nilai</a>
                                    </h3>
                                    <span class="card-meta">Lihat rekap nilai secara transparan</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="category-card">
                                <div class="card-icon">
                                    <ion-icon name="checkmark-done-outline"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="h3 card-title">
                                        <a>Absensi Digital</a>
                                    </h3>
                                    <span class="card-meta">Pantau catatan kehadiranmu</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="category-card">
                                <div class="card-icon">
                                    <ion-icon name="wallet-outline"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="h3 card-title">
                                        <a>Pembayaran SPP</a>
                                    </h3>
                                    <span class="card-meta">Bayar tagihan sekolah online</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="category-card">
                                <div class="card-icon">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="h3 card-title">
                                        <a>Jadwal Pelajaran</a>
                                    </h3>
                                    <span class="card-meta">Lihat jadwal kelasmu kapan saja</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="category-card">
                                <div class="card-icon">
                                    <ion-icon name="chatbubbles-outline"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="h3 card-title">
                                        <a>Komunikasi Guru</a>
                                    </h3>
                                    <span class="card-meta">Terhubung langsung dengan pengajar</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
            </div>

            <!-- #ABOUT-->
            <section class="section about" id="about" aria-label="about">
                <div class="container">

                <figure class="about-banner">
                    <img src="{{ asset('images/kepsek.JPG') }}" width="100" height="580" loading="lazy"
                        alt="Gambar Latar Belakang Baru" class="w-100 about-img" style="border-radius: 10px;">

                    <img src="{{ asset('images/kepsek.JPG') }}" width="188" height="242" loading="lazy"
                        aria-hidden="true" class="abs-img abs-img-1" style="border: 5px solid #ffffff; border-radius: 10px;">
                </figure>

                    <div class="about-content">
                        <p class="section-subtitle">Tentang SIGEMA</p>
                        <h2 class="h2 section-title">Platform Terintegrasi untuk Kebutuhan Akademik Anda</h2>
                        <ul class="about-list">
                            <li class="about-item">
                                <div class="item-icon item-icon-1">
                                    <img src="{{ asset('frontend/assets/images/about-icon-1.png') }}" width="30"
                                        height="30" loading="lazy" aria-hidden="true">
                                </div>
                                <div>
                                    <h3 class="h3 item-title">Guru Profesional & Berpengalaman</h3>
                                    <p class="item-text">
                                        Materi diajarkan oleh para pendidik ahli di bidangnya untuk memastikan kualitas pembelajaran terbaik.
                                    </p>
                                </div>
                            </li>
                            <li class="about-item">
                                <div class="item-icon item-icon-2">
                                    <img src="{{ asset('frontend/assets/images/about-icon-2.png') }}" width="30"
                                        height="30" loading="lazy" aria-hidden="true">
                                </div>
                                <div>
                                    <h3 class="h3 item-title">Kurikulum Terkini</h3>
                                    <p class="item-text">
                                        Semua materi pembelajaran selalu diperbarui untuk mengikuti perkembangan ilmu pengetahuan dan teknologi.
                                    </p>
                                </div>
                            </li>
                            <li class="about-item">
                                <div class="item-icon item-icon-3">
                                    <img src="{{ asset('frontend/assets/images/about-icon-3.png') }}" width="30"
                                        height="30" loading="lazy" aria-hidden="true">
                                </div>
                                <div>
                                    <h3 class="h3 item-title">Administrasi Terpusat</h3>
                                    <p class="item-text">
                                        Kelola semua kebutuhan administrasi, mulai dari absensi hingga pembayaran, dalam satu platform yang mudah diakses.
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <a href="{{ route('about.frontend') }}" class="btn btn-primary">
                            <span class="span">Pelajari Lebih Lanjut</span>
                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                        </a>
                    </div>

                </div>
            </section>

            <!--- #COURSE-->
            <div data-aos="fade-up" data-aos-duration="2000">
            <section class="section course" id="courses" aria-label="course"
                style="background-image: url('{{ asset('frontend/assets/images/course-bg.jpg') }}')">
                <div class="container">
                    <p class="section-subtitle">Informasi Sekolah</p>
                    <h2 class="h2 section-title">Berita Terbaru</h2>
                    <ul class="grid-list">
                        <li>
                            <div class="course-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=2073&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="370"
                                        height="270" loading="lazy" alt="Buku-buku di perpustakaan"
                                        class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <ul class="card-meta-list">
                                        <li class="card-meta-item">
                                            <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>
                                            <span class="card-meta-text">10 - 15 Nov 2025</span>
                                        </li>
                                    </ul>
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Jadwal Ujian Tengah Semester Ganjil</a>
                                    </h3>
                                    <div class="card-footer">
                                        <a href="#" class="btn-link">
                                            <span class="span">Baca Selengkapnya</span>
                                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="course-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="370"
                                        height="270" loading="lazy"
                                        alt="Siswa berkumpul di halaman sekolah" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <ul class="card-meta-list">
                                        <li class="card-meta-item">
                                            <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>
                                            <span class="card-meta-text">20 Des 2025</span>
                                        </li>
                                    </ul>
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Kegiatan Class Meeting Akhir Semester</a>
                                    </h3>
                                    <div class="card-footer">
                                        <a href="#" class="btn-link">
                                            <span class="span">Baca Selengkapnya</span>
                                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="course-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="370"
                                        height="270" loading="lazy" alt="Suasana kelas yang ceria"
                                        class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <ul class="card-meta-list">
                                        <li class="card-meta-item">
                                            <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>
                                            <span class="card-meta-text">25 Des - 5 Jan</span>
                                        </li>
                                    </ul>
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Informasi Libur Semester dan Awal Masuk</a>
                                    </h3>
                                    <div class="card-footer">
                                        <a href="#" class="btn-link">
                                            <span class="span">Baca Selengkapnya</span>
                                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    {{-- <a href="#" class="btn btn-primary">
                        <span class="span">Lihat Semua Berita</span>
                        <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                    </a> --}}

                </div>
            </section>
            </div>

            <!-- #CTA-->
            <section class="section cta" aria-label="workshop"
                style="background-image: url('{{ asset('frontend/assets/images/cta-bg.png') }}')">
                <div class="container">

                    {{-- <figure class="cta-banner">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="580" height="380"
                            loading="lazy" alt="Siswa berdiskusi" class="img-cover">
                    </figure> --}}

                    <figure class="cta-banner">
                        <img src="{{ asset('images/siswa_gema.jpg') }}"
                            width="700" height="378" loading="lazy" alt="Siswa berdiskusi" class="img-cover">
                    </figure>

                    <div class="cta-content">
                        <p class="section-subtitle">Masuk ke pembelajaran?</p>
                        <h2 class="h2 section-title">Masuk ke Akun Anda Sekarang</h2>
                        <p class="section-text">
                        Login untuk mengakses dashboard personal Anda, melihat materi pelajaran, mengerjakan tugas, memantau nilai, dan mengelola semua kebutuhan akademik Anda dengan mudah.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            <span class="span">Login di Sini</span>
                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                        </a>
                    </div>

                </div>
            </section>

            <!-- #EVENT-->
            <div data-aos="fade-up" data-aos-duration="2000">
            <section class="section event" id="event" aria-label="event">
                <div class="container">

                    <p class="section-subtitle">Fasilitas Sekolah</p>

                    <h2 class="h2 section-title">Lingkungan Belajar yang Mendukung</h2>

                    <ul class="grid-list">

                        <li>
                            <div class="event-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="370"
                                        height="250" loading="lazy"
                                        alt="Perpustakaan sekolah" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Perpustakaan Lengkap & Nyaman</a>
                                    </h3>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="event-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="370"
                                        height="250" loading="lazy"
                                        alt="Laboratorium komputer" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Laboratorium Komputer Modern</a>
                                    </h3>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="event-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" width="370"
                                        height="250" loading="lazy"
                                        alt="Lapangan olahraga" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Laboratorium Biologi</a>
                                    </h3>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="event-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        width="370" height="250" loading="lazy" alt="Lapangan olahraga" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Laboratorium Kimia</a>
                                    </h3>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="event-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        width="370" height="250" loading="lazy" alt="Lapangan olahraga" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Lapangan Olahraga Serbaguna yang luas</a>
                                    </h3>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="event-card">
                                <figure class="card-banner">
                                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        width="370" height="250" loading="lazy" alt="Lapangan olahraga" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3">
                                        <a href="#" class="card-title">Kelas Ber - AC 3</a>
                                    </h3>
                                </div>
                            </div>
                        </li>

                    </ul>

                </div>
            </section>
            </div>

            <!-- #NEWSLETTER-->
            {{-- section: banner diskon --}}
            <section class="section category" aria-label="category">
                <div class="container-fluid banner">
                    <img src="{{ asset('images/diskon_banner.png') }}" alt="Banner Promosi" class="w-100"
                        style="align-items: center;">
                </div>
            </section>
            {{-- <section class="section newsletter" aria-label="newsletter"
                style="background-image: url('{{ asset('frontend/assets/images/newsletter-bg.jpg') }}')">
                <div class="container">
                    <p class="section-subtitle">Tetap Terhubung</p>
                    <h2 class="h2 section-title">Dapatkan Info Terbaru dari SIGEMA</h2>
                    <form action="" class="newsletter-form">
                        <div class="input-wrapper">
                            <input type="email" name="email_address" aria-label="email"
                                placeholder="Masukkan alamat email Anda" required class="email-field">
                            <ion-icon name="mail-open-outline" aria-hidden="true"></ion-icon>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <span class="span">Kirim</span>
                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                        </button>
                    </form>
                </div>
            </section> --}}

            <!-- #LOCATION MAP -->
            <div data-aos="fade-up" data-aos-duration="2000">
            <section class="section location-map">
                <div class="container">
                    <p class="section-subtitle" style="text-align: center;">KAMI BERADA DISINI</p>
                    <h2 class="h2 section-title" style="text-align: center; margin-bottom: 20px;">Lokasi Kami</h2>

                    <div class="map-container" style="width: 100%;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.561913079362!2d112.71861507668349!3d-7.2905802716629005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb0078f278f1%3A0xacffac6bb08a7a21!2sSMA%20GEMA%2045%20Surabaya!5e0!3m2!1sid!2sid!4v1765270449963!5m2!1sid!2sid"
                            width="100%" height="450" style="border:0; mb-2" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </section>
            </div>
        </article>
    </main>

    <!--- #BACK TO TOP-->
    <a href="#top" class="back-top-btn" aria-label="Back to top" data-back-top-btn>
        <ion-icon name="arrow-up"></ion-icon>
    </a>
@endsection

