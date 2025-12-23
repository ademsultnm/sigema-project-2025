<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- favicon-->
    <link rel="shortcut icon" href="{{ asset('images/logo_gema.ico') }}" type="image/svg+xml">
    <title>@yield('title', 'Home')</title>
    {{-- efek delay --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>

    @include('frontend.partials.styles')
</head>

<body>
    <!--- #HEADER-->
    <header class="header" data-header>
        @include('frontend.partials.navbar')
    </header>
    <!--- #SEARCH BOX-->
    <div class="search-container" data-search-box>
        <div class="container">

            <button class="search-close-btn" aria-label="Close search" data-search-toggler>
                <ion-icon name="close-outline"></ion-icon>
            </button>

            <div class="search-wrapper">
                <input type="search" name="search" placeholder="Search Here..." aria-label="Search"
                    class="search-field">

                <button class="search-submit" aria-label="Submit" data-search-toggler>
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>

        </div>
    </div>
    @yield('content')
    <!--- #BACK TO TOP-->
    <a href="#top" class="back-top-btn" aria-label="Back to top" data-back-top-btn>
        <ion-icon name="arrow-up"></ion-icon>
    </a>
    <!--#FOOTER-->
    <footer class="footer">
        @include('frontend.partials.footer')
    </footer>
    @include('frontend.partials.scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
