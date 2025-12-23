@extends('frontend.layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="container my-5" style="margin-top: 8%; margin-bottom: 3%;">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center">Kontak Kami</h1>
                <p class="text-center">Akses kontak personal kami disini.</p><br>

                <ul class="footer-list">
                    <li class="footer-item">
                        <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                        <a href="https://maps.app.goo.gl/4jTFbFgbomhxkgrN6" target="_blank" class="footer-link">
                            Jl. Mayjend Sungkono, No. 106, Surabaya
                        </a>
                    </li>
                    <li class="footer-item">
                        <ion-icon name="call" aria-hidden="true"></ion-icon>
                        <a href="tel:+0315621570" class="footer-link">(031) 5621570</a>
                    </li>
                    <li class="footer-item">
                        <ion-icon name="call" aria-hidden="true"></ion-icon>
                        <a href="tel:+6287864411265" class="footer-link">087864411265 | Kesiswaan</a>
                    </li>
                    <li class="footer-item">
                        <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
                        <a href="mailto:smagemapatma@gmail.com" class="footer-link">smagemapatma@gmail.com</a>
                    </li>
                </ul>

                {{-- <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="margin-bottom: 20%;">Send Message</button>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
@endsection
