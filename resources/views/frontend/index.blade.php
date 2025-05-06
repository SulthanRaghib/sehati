@extends('home')
@section('main-content')
    @if (Auth::check())
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="100">
                            {{-- <div class="company-badge mb-4">
                        <i class="bi bi-gear-fill me-2"></i>
                        Working for your success
                    </div> --}}

                            <h1 class="mb-4">
                                @php
                                    $nama = explode(' ', Auth::user()->name);
                                    $getFirstName = $nama[0];
                                @endphp
                                Haloo, {{ $getFirstName }} <br />
                                <span class="accent-text">Bagaimana kabarmu hari ini?</span>
                            </h1>

                            <p class="mb-4 mb-md-5">
                                Ingat, kamu nggak sendirian. Kami di sini untuk mendengarkan dan membantumu.
                                Yuk, lanjutkan konseling yang sudah kamu mulai, atau ceritakan hal baru yang sedang kamu
                                alami hari ini.
                                Versi terbaik dari dirimu sedang dalam perjalanan! 💙
                            </p>

                            <div class="hero-buttons">
                                <a href="{{ route('siswa.konseling') }}" class="btn btn-primary me-0 me-sm-2 mx-1">Mulai
                                    Konseling</a>
                                {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                            class="btn btn-link mt-2 mt-sm-0 glightbox">
                            <i class="bi bi-play-circle me-1"></i>
                            Play Video
                        </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="{{ url('mine/img/hero.png') }}" alt="Hero Image" class="img-fluid" />
                        </div>
                    </div>
                </div>

                <script>
                    fetch("/api/quote")
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById("quote-text").innerText = data.original;
                            document.getElementById("quote-translation").innerText = `"${data.translated}"`;
                            document.getElementById("quote-author").innerText = `- ${data.author}`;
                        })
                        .catch(error => console.error("Fetch error:", error));
                </script>

                <div class="container section-title pb-0 pt-5" data-aos="fade-up">
                    <h2>Quote of the Day</h2>
                </div>
                <section id="call-to-action" class="call-to-action section pt-0" style="background: none">
                    <!-- Section Title -->
                    <div class="container" data-aos="fade-up" data-aos-delay="100">
                        <div class="row content justify-content-center align-items-center position-relative">
                            <div class="col-lg-8 mx-auto text-center">
                                <h1 id="quote-text" class="display-5 text-white"
                                    style="font-size: 1.8rem; font-weight: 600">
                                    <h5 id="quote-translation" style="font-style: italic; color:white;"></h5>
                                    <p id="quote-author" class="mb-0"></p>
                            </div>

                            <!-- Abstract Background Elements -->
                            <div class="shape shape-1">
                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M47.1,-57.1C59.9,-45.6,68.5,-28.9,71.4,-10.9C74.2,7.1,71.3,26.3,61.5,41.1C51.7,55.9,35,66.2,16.9,69.2C-1.3,72.2,-21,67.8,-36.9,57.9C-52.8,48,-64.9,32.6,-69.1,15.1C-73.3,-2.4,-69.5,-22,-59.4,-37.1C-49.3,-52.2,-32.8,-62.9,-15.7,-64.9C1.5,-67,34.3,-68.5,47.1,-57.1Z"
                                        transform="translate(100 100)"></path>
                                </svg>
                            </div>

                            <div class="shape shape-2">
                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M41.3,-49.1C54.4,-39.3,66.6,-27.2,71.1,-12.1C75.6,3,72.4,20.9,63.3,34.4C54.2,47.9,39.2,56.9,23.2,62.3C7.1,67.7,-10,69.4,-24.8,64.1C-39.7,58.8,-52.3,46.5,-60.1,31.5C-67.9,16.4,-70.9,-1.4,-66.3,-16.6C-61.8,-31.8,-49.7,-44.3,-36.3,-54C-22.9,-63.7,-8.2,-70.6,3.6,-75.1C15.4,-79.6,28.2,-58.9,41.3,-49.1Z"
                                        transform="translate(100 100)"></path>
                                </svg>
                            </div>

                            <!-- Dot Pattern Groups -->
                            <div class="dots dots-1">
                                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <pattern id="dot-pattern" x="0" y="0" width="20" height="20"
                                        patternUnits="userSpaceOnUse">
                                        <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                                    </pattern>
                                    <rect width="100" height="100" fill="url(#dot-pattern)"></rect>
                                </svg>
                            </div>

                            <div class="dots dots-2">
                                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <pattern id="dot-pattern-2" x="0" y="0" width="20" height="20"
                                        patternUnits="userSpaceOnUse">
                                        <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                                    </pattern>
                                    <rect width="100" height="100" fill="url(#dot-pattern-2)"></rect>
                                </svg>
                            </div>

                            <div class="shape shape-3">
                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M43.3,-57.1C57.4,-46.5,71.1,-32.6,75.3,-16.2C79.5,0.2,74.2,19.1,65.1,35.3C56,51.5,43.1,65,27.4,71.7C11.7,78.4,-6.8,78.3,-23.9,72.4C-41,66.5,-56.7,54.8,-65.4,39.2C-74.1,23.6,-75.8,4,-71.7,-13.2C-67.6,-30.4,-57.7,-45.2,-44.3,-56.1C-30.9,-67,-15.5,-74,0.7,-74.9C16.8,-75.8,33.7,-70.7,43.3,-57.1Z"
                                        transform="translate(100 100)"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </section>
                {{-- <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 id="quote-text" class="display-6 my-2" style="font-size: 2rem; color: #2d465e"></h1>
                        <h5 id="quote-translation" style="font-style: italic; color:#0d83fd"></h5>
                        <p id="quote-author"></p>
                    </div>
                </div> --}}
            </div>
        </section>
        <!-- /Hero Section -->
    @else
        {{-- kalau user belom login --}}
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <h1 class="mb-4">
                                SEHATI, <br />
                                <span class="accent-text">Sehat Mental dan Hati</span>
                            </h1>

                            <p class="mb-4 mb-md-5">
                                “Merasa cemas, stres, atau butuh tempat bercerita?... Yuk, mulai langkah pertama menuju
                                versi terbaik dari dirimu!”
                            </p>

                            <div class="hero-buttons">
                                <a href="{{ route('siswa.konseling') }}" class="btn btn-primary me-0 me-sm-2 mx-1">Mulai
                                    Konseling</a>
                                {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                            class="btn btn-link mt-2 mt-sm-0 glightbox">
                            <i class="bi bi-play-circle me-1"></i>
                            Play Video
                        </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="{{ url('mine/img/hero.png') }}" alt="Hero Image" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /Hero Section -->
        <!-- Hero Section -->
        {{-- <section id="about" class="about section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <h1 class="mb-4">
                                <span class="accent-text">SMK Amaliyah</span>
                            </h1>

                            <p class="mb-4 mb-md-5">
                                SMK Amaliyah Jakarta adalah sekolah kejuruan unggulan di bawah Yayasan Ikhwanul Amaliyah,
                                berlokasi di lingkungan asri Jakarta Selatan. Berdiri sejak 2001, sekolah ini membekali
                                siswa dengan kompetensi Keperawatan, Akuntansi, dan Pemasaran melalui kurikulum modern,
                                pendekatan religius, dan pembelajaran berbasis digital.
                            </p>

                            <div class="hero-buttons">
                                <a href="#about" class="btn btn-primary me-0 me-sm-2 mx-1">Mulai Konseling</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="{{ url('mine/img/SMK-Amaliyah-removebg.png') }}" alt="Hero Image" class="img-fluid"
                                style="border-radius: 10%">
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- /Hero Section -->

        <!-- Features Cards Section -->
        <section id="features-cards" class="features-cards section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Features</h2>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="feature-box orange">
                            <i class="bi bi-person-check-fill"></i>
                            <h4>Konseling</h4>
                            <p>
                                Dapatkan bimbingan dari guru BK kami yang berpengalaman. Kami siap membantu Anda
                                mengatasi masalah pribadi, akademis, dan sosial.
                            </p>
                        </div>
                    </div>
                    <!-- End Feature Borx-->

                    <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <div class="feature-box blue">
                            <i class="bi bi-people"></i>
                            <h4>Konsultasi</h4>
                            <p>
                                Mulai konsultasi dengan guru BK kami. Anda dapat memilih untuk melakukan konsultasi secara
                                langsung atau melalui platform online.
                            </p>
                        </div>
                    </div>
                    <!-- End Feature Borx-->

                    <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                        <div class="feature-box green">
                            <i class="bi bi-chat-left-text"></i>
                            <h4>Riwayat Konsultasi</h4>
                            <p>
                                Simpan riwayat konsultasi Anda untuk referensi di masa mendatang. Anda dapat melihat
                                catatan dan rekomendasi dari guru BK.
                            </p>
                        </div>
                    </div>
                    <!-- End Feature Borx-->

                    <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="feature-box red">
                            <i class="bi bi-journal-text"></i>
                            <h4>Artikel & Tips</h4>
                            <p>
                                Akses artikel dan tips kesehatan mental yang bermanfaat. Kami menyediakan informasi
                                terkini tentang kesehatan mental dan cara menjaga kesejahteraan Anda.
                            </p>
                        </div>
                    </div>
                    <!-- End Feature Borx-->
                </div>
            </div>
        </section>
        <!-- /Features Cards Section -->

        <!-- Call To Action Section -->
        <script>
            fetch("/quote")
                .then(res => res.json())
                .then(data => {
                    document.getElementById("quote-text").innerText = data.original;
                    document.getElementById("quote-translation").innerText = `"${data.translated}"`;
                    document.getElementById("quote-author").innerText = `- ${data.author}`;
                })
                .catch(error => console.error("Fetch error:", error));
        </script>
        <div class="container section-title pb-0" data-aos="fade-up">
            <h2>Quote of the Day</h2>
        </div>
        <!-- End Section Title -->
        <section id="call-to-action" class="call-to-action section pt-0">
            <!-- Section Title -->
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row content justify-content-center align-items-center position-relative">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 id="quote-text" class="display-5 mb-4 text-white"></h1>
                        <h5 id="quote-translation" style="font-style: italic; color:white;"></h5>
                        <p id="quote-author" class="mb-4"></p>
                    </div>

                    <!-- Abstract Background Elements -->
                    <div class="shape shape-1">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M47.1,-57.1C59.9,-45.6,68.5,-28.9,71.4,-10.9C74.2,7.1,71.3,26.3,61.5,41.1C51.7,55.9,35,66.2,16.9,69.2C-1.3,72.2,-21,67.8,-36.9,57.9C-52.8,48,-64.9,32.6,-69.1,15.1C-73.3,-2.4,-69.5,-22,-59.4,-37.1C-49.3,-52.2,-32.8,-62.9,-15.7,-64.9C1.5,-67,34.3,-68.5,47.1,-57.1Z"
                                transform="translate(100 100)"></path>
                        </svg>
                    </div>

                    <div class="shape shape-2">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M41.3,-49.1C54.4,-39.3,66.6,-27.2,71.1,-12.1C75.6,3,72.4,20.9,63.3,34.4C54.2,47.9,39.2,56.9,23.2,62.3C7.1,67.7,-10,69.4,-24.8,64.1C-39.7,58.8,-52.3,46.5,-60.1,31.5C-67.9,16.4,-70.9,-1.4,-66.3,-16.6C-61.8,-31.8,-49.7,-44.3,-36.3,-54C-22.9,-63.7,-8.2,-70.6,3.6,-75.1C15.4,-79.6,28.2,-58.9,41.3,-49.1Z"
                                transform="translate(100 100)"></path>
                        </svg>
                    </div>

                    <!-- Dot Pattern Groups -->
                    <div class="dots dots-1">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <pattern id="dot-pattern" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                            </pattern>
                            <rect width="100" height="100" fill="url(#dot-pattern)"></rect>
                        </svg>
                    </div>

                    <div class="dots dots-2">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <pattern id="dot-pattern-2" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                            </pattern>
                            <rect width="100" height="100" fill="url(#dot-pattern-2)"></rect>
                        </svg>
                    </div>

                    <div class="shape shape-3">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M43.3,-57.1C57.4,-46.5,71.1,-32.6,75.3,-16.2C79.5,0.2,74.2,19.1,65.1,35.3C56,51.5,43.1,65,27.4,71.7C11.7,78.4,-6.8,78.3,-23.9,72.4C-41,66.5,-56.7,54.8,-65.4,39.2C-74.1,23.6,-75.8,4,-71.7,-13.2C-67.6,-30.4,-57.7,-45.2,-44.3,-56.1C-30.9,-67,-15.5,-74,0.7,-74.9C16.8,-75.8,33.7,-70.7,43.3,-57.1Z"
                                transform="translate(100 100)"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Call To Action Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $konselingCount }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Total Konseling</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $guruBKCount }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Guru BK</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $siswaTerbantu }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Siswa Terbantu</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $artikelCount }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Artikel & Tips</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->
                </div>
            </div>
        </section>
        <!-- /Stats Section -->
    @endif
@endsection
