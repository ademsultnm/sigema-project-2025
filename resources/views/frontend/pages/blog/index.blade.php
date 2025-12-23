@extends('frontend.layouts.app')

@section('title', 'Blog')
@section('content')
    <!-- ======= Breadcrumbs ======= -->
    {{-- <section class="breadcrumbs" style="margin-top: 3%;">
        <div class="container">
            <ol>
                <li><a href="/">Home</a></li>
                {{-- <li><a href="#">Blog</a></li> --}}
                {{-- <li>Post</li> --}}
                {{-- {{ $item->title }} --}}
            {{-- </ol> --}}
            {{-- <h2>Post</h2> --}}
            {{-- {{ $item->title }} --}}
        {{-- </div> --}}
    {{-- </section> --}}
    <!-- End Breadcrumbs -->


    <div class="page-content" style="margin-top: 2%; text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <section class="section blog" id="blog" aria-label="blog">
                        <div class="container">
                            <h2 class="h2 section-title">Blog Terkini</h2>
                            <div class="row">

                                {{-- @foreach ($posts as $post) --}}
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <img src="" class="card-img-top" alt="">
                                        <div class="card-body" style="text-align: center">
                                            <h3 class="card-title">KUMPULAN BLOG SEPUTAR SMA GEMA 45 SURABAYA</h3>
                                            {{-- <p class="card-text"></p> --}}
                                        {{-- <a href="#" class="btn btn-primary">
                                            <span class="span">Lihat Semua Berita</span>
                                            <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                        </a> --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- @endforeach --}}

                            </div>
                            <div class="pagination"></div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    {{-- @include('frontend.partials.sidebar') --}}
                </div>
            </div>
        </div>
    </div>
@endsection
