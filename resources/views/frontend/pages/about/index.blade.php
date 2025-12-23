@extends('frontend.layouts.app')

@section('title', 'About')

@section('content')
    <!-- #ABOUT-->
    <section class="section about" id="about" aria-label="about" style="margin-top: 8%;">
        <div class="container">

            <figure class="about-banner">

                <img src="{{ asset('frontend/assets/images/about-banner.jpg') }}" width="450" height="590" loading="lazy"
                    alt="about banner" class="w-100 about-img">

                <img src="{{ asset('frontend/assets/images/about-abs-1.jpg') }}" width="188" height="242"
                    loading="lazy" aria-hidden="true" class="abs-img abs-img-1">

                <img src="{{ asset('frontend/assets/images/about-abs-2.jpg') }}" width="150" height="200"
                    loading="lazy" aria-hidden="true" class="abs-img abs-img-2">

            </figure>

            <div class="about-content">
                <p class="section-subtitle">Tentang SIGEMA</p>
                <h2 class="h2 section-title">Platform Terintegrasi untuk Kebutuhan Akademik Anda</h2>
                <ul class="about-list">
                    <li class="about-item">
                        <div class="item-icon item-icon-1">
                            <img src="{{ asset('frontend/assets/images/about-icon-1.png') }}" width="30" height="30" loading="lazy"
                                aria-hidden="true">
                        </div>
                        <div>
                            <h3 class="h3 item-title">Guru Profesional & Berpengalaman</h3>
                            <p class="item-text">
                                Materi diajarkan oleh para pendidik ahli di bidangnya untuk memastikan kualitas pembelajaran
                                terbaik.
                            </p>
                        </div>
                    </li>
                    <li class="about-item">
                        <div class="item-icon item-icon-2">
                            <img src="{{ asset('frontend/assets/images/about-icon-2.png') }}" width="30" height="30" loading="lazy"
                                aria-hidden="true">
                        </div>
                        <div>
                            <h3 class="h3 item-title">Kurikulum Terkini</h3>
                            <p class="item-text">
                                Semua materi pembelajaran selalu diperbarui untuk mengikuti perkembangan ilmu pengetahuan dan
                                teknologi.
                            </p>
                        </div>
                    </li>
                    <li class="about-item">
                        <div class="item-icon item-icon-3">
                            <img src="{{ asset('frontend/assets/images/about-icon-3.png') }}" width="30" height="30" loading="lazy"
                                aria-hidden="true">
                        </div>
                        <div>
                            <h3 class="h3 item-title">Administrasi Terpusat</h3>
                            <p class="item-text">
                                Kelola semua kebutuhan administrasi, mulai dari absensi hingga pembayaran, dalam satu platform yang
                                mudah diakses.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
@endsection
