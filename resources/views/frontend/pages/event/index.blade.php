@extends('frontend.layouts.app')
@section('title', 'Event')
@section('content')
        <!-- #EVENT-->
    <div data-aos="fade-up" data-aos-duration="2000"></div>
    <section class="section event" id="event" aria-label="event" style="margin-top: 3%;">
        <div class="container">
            <p class="section-subtitle">Kegiatan Mendatang</p>
            <h2 class="h2 section-title">Ayo Menjelajah!</h2>
            <ul class="grid-list">
                <li>
                    <div class="event-card">
                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/futsal.png') }}" width="370"
                                height="250" loading="lazy"
                                alt="Innovation & Technological Entrepreneurship Team" class="img-cover">
                        </figure>
                        <time class="badge" datetime="2022-12-04">20 Jan 2026</time>
                        <div class="card-content">
                            <address class="card-address">
                                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                                <span class="span">Gor Jayabaya - Kediri</span>
                            </address>  
                            <h3 class="h3">
                                <a href="#" class="card-title">Allievo Futsal Championship</a>
                            </h3>
                            <a href="https://www.instagram.com/allievo_champion/" class="btn-link">
                                <span class="span">Lihat Info Pendaftaran</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="event-card">
                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/event-2.jpg') }}" width="370"
                                height="250" loading="lazy"
                                alt="Virtual Spring Part-time Jobs Fair for Student" class="img-cover">
                        </figure>
                        <time class="badge" datetime="2022-12-04">20 Jan 2026</time>
                        <div class="card-content">
                            <address class="card-address">
                                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                                <span class="span">Gor Unesa Lidah Wetan</span>
                            </address>
                            <h3 class="h3">
                                <a href="#" class="card-title">Piala Walikota Futsal Championship</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">Lihat Info Pendaftaran</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="event-card">
                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/event-3.jpg') }}" width="370"
                                height="250" loading="lazy"
                                alt="Explorations of Regional Chief Executive Network" class="img-cover">
                        </figure>
                        <time class="badge" datetime="2022-12-04">20 Jan 2026</time>
                        <div class="card-content">
                            <address class="card-address">
                                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                                <span class="span">Gor Unesa Lidah Wetan</span>
                            </address>
                            <h3 class="h3">
                                <a href="#" class="card-title">Piala Walikota Futsal Championship</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">Lihat Info Pendaftaran</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="event-card">
                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/futsal.png') }}" width="370" height="250" loading="lazy"
                                alt="Innovation & Technological Entrepreneurship Team" class="img-cover">
                        </figure>
                        <time class="badge" datetime="2022-12-04">20 Jan 2026</time>
                        <div class="card-content">
                            <address class="card-address">
                                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                                <span class="span">Gor Jayabaya - Kediri</span>
                            </address>
                            <h3 class="h3">
                                <a href="#" class="card-title">Allievo Futsal Championship</a>
                            </h3>
                            <a href="https://www.instagram.com/allievo_champion/" class="btn-link">
                                <span class="span">Lihat Info Pendaftaran</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="event-card">
                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/event-2.jpg') }}" width="370" height="250" loading="lazy"
                                alt="Virtual Spring Part-time Jobs Fair for Student" class="img-cover">
                        </figure>
                        <time class="badge" datetime="2022-12-04">20 Jan 2026</time>
                        <div class="card-content">
                            <address class="card-address">
                                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                                <span class="span">Gor Unesa Lidah Wetan</span>
                            </address>
                            <h3 class="h3">
                                <a href="#" class="card-title">Piala Walikota Futsal Championship</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">Lihat Info Pendaftaran</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="event-card">
                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/event-3.jpg') }}" width="370" height="250" loading="lazy"
                                alt="Explorations of Regional Chief Executive Network" class="img-cover">
                        </figure>
                        <time class="badge" datetime="2022-12-04">20 Jan 2026</time>
                        <div class="card-content">
                            <address class="card-address">
                                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                                <span class="span">Gor Unesa Lidah Wetan</span>
                            </address>
                            <h3 class="h3">
                                <a href="#" class="card-title">Piala Walikota Futsal Championship</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">Lihat Info Pendaftaran</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>

@endsection
