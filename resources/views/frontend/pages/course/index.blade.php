@extends('frontend.layouts.app')
@section('title', 'Course')
@section('content')
    <!--- #COURSE-->
    <section class="section course" id="courses" aria-label="course"
        style="background-image: url('{{ asset('frontend/assets/images/course-bg.jpg') }}')" style="margin-top: 20%;">
        <div class="container">

            <p class="section-subtitle">kategori Non-Akademik</p>

            <h2 class="h2 section-title">Ekstrakurikuler</h2>

            <ul class="grid-list">

                {{-- FUTSAL --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270"
                                loading="lazy" alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">Futsal</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

                {{-- VOLI --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270" loading="lazy"
                                alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">Voli</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

                {{-- BASKET --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270" loading="lazy"
                                alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">Basket</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

                {{-- PASKIBRA --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270" loading="lazy"
                                alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">PASKIBRA</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

                {{-- PRAMUKA --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270" loading="lazy"
                                alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">PRAMUKA</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

                {{-- TARI TRADISIONAL --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270" loading="lazy"
                                alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">Tari Tradisional</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

                {{-- PENCAK SILAT --}}
                <li>
                    <div class="course-card">

                        <figure class="card-banner">
                            <img src="{{ asset('frontend/assets/images/course-1.jpg') }}" width="370" height="270" loading="lazy"
                                alt="Competitive Strategy law for all students" class="img-cover">
                        </figure>

                        <div class="card-actions">

                            <span class="badge">Intermediate</span>

                            <button class="whishlist-btn" aria-label="Add to whishlist" data-whish-btn>
                                <ion-icon name="heart"></ion-icon>
                            </button>

                        </div>

                        <div class="card-content">

                            <ul class="card-meta-list">

                                <li class="card-meta-item">
                                    <ion-icon name="reader-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">15.00 - 17.00 WIB</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                                    <time datetime="PT18H15M44S" class="card-meta-text">Selasa & Jumat</time>
                                </li>

                            </ul>

                            <h3 class="h3">
                                <a href="#" class="card-title">Pencak Silat</a>
                            </h3>

                            <div class="rating-wrapper">

                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <span class="rating-text">(18 Review)</span>

                            </div>

                            <div class="card-footer">

                                <div class="card-price">
                                    <span class="span">Rp. 10.000,-</span>

                                    <del class="del">Rp. 15.000,-</del>
                                </div>

                                <div class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>

                                    <span class="card-meta-text">47 Students</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </li>

            </ul>

            <a href="#" class="btn btn-primary">
                <span class="span">View All Courses</span>

                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
            </a>

        </div>
    </section>

@endsection
