<div class="container">
    <div class="footer-top">
        <div class="footer-brand">
            <div class="logo-container">
                <a href="#">
                    <img src="{{ asset('images/logo_gema.ico') }}" alt="Logo SMA GEMA 45" class="school-logo" style="width: 20%">
                </a>
            </div>
            
            {{-- judul konten di footer --}}
            <h3 class="judul sekolah">SMA GEMA 45</h3>
            <p class="section-text">
                Sekolah berwawasan kebangsaan di Surabaya dibawah naungan Yayasan Perjuangan 45 Provinsi Jawa Timur. 
            </p>
            
            <ul class="social-list">
                <li>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                        <ion-icon name="logo-facebook"></ion-icon>
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                        <ion-icon name="logo-twitter"></ion-icon>
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                        <ion-icon name="logo-linkedin"></ion-icon>
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/smagpatma/" target="_blank" rel="noopener noreferrer" class="social-link">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Jam Operasional -->
        <ul class="footer-list">
            <li>
                <p class="footer-list-title">Jam Operasional</p>
            </li>
            <li class="footer-item">
                <ion-icon name="calendar" aria-hidden="true"></ion-icon>
                <a><strong>Senin - Kamis</strong><br>08.00 - 15.00 WIB</a>
            </li><br>
            <li class="footer-item">
                <ion-icon name="calendar" aria-hidden="true"></ion-icon>
                <a><strong>Jumat</strong><br>08.00 - 14.00 WIB</a>
            </li><br>
            <li class="footer-item">
                <ion-icon name="calendar" aria-hidden="true"></ion-icon>
                <a><strong>Sabtu - Minggu</strong><br>07.00 - 15.00 WIB</a>
            </li>
        </ul>

        {{-- informasi Instansi --}}
        <ul class="footer-list">
            <li>
                <p class="footer-list-title">Informasi Instansi</p>
            </li>
            <li class="footer-item">
                <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                <a href="https://maps.app.goo.gl/4jTFbFgbomhxkgrN6" target="_blank" class="footer-link">
                    Jl. Mayjend Sungkono, No. 106, Surabaya
                </a>
            </li>
            <li class="footer-item">
                <ion-icon name="call" aria-hidden="true"></ion-icon>
                <a href="tel:+0315621570" class="footer-link">(031)5621570</a>
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

        {{-- jelajahi --}}
        <ul class="footer-list">
            <li>
                <p class="footer-list-title">Jelajahi</p>
            </li>
            <li>
                <a href="{{ route('about.frontend') }}" class="footer-link">
                    <ion-icon name="chevron-forward" aria-hidden="true"></ion-icon>
                    <span class="span">Tentang Kami</span>
                </a>
            </li>
            <li>
                <a href="#" class="footer-link">
                    <ion-icon name="chevron-forward" aria-hidden="true"></ion-icon>
                    <span class="span">Esktrakurikuler</span>
                </a>
            </li>
            <li>
                <a href="#" class="footer-link">
                    <ion-icon name="chevron-forward" aria-hidden="true"></ion-icon>
                    <span class="span">Kegiatan</span>
                </a>
            </li>
            <li>
                <a href="#" class="footer-link">
                    <ion-icon name="chevron-forward" aria-hidden="true"></ion-icon>
                    <span class="span">Blog</span>
                </a>
            </li>
            <li>
                <a href="#" class="footer-link">
                    <ion-icon name="chevron-forward" aria-hidden="true"></ion-icon>
                    <span class="span">Kontak</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- copyright --}}
    <div class="footer-bottom">
        <p class="copyright">
            Copyright 2025. All Rights Reserved by <a href="#" class="copyright-link">Adam Sultonunmubin</a>
        </p>
    </div>

</div>
