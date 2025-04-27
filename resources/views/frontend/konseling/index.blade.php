@extends('home')
@section('main-content')
    <script>
        channel.bind('konseling-baru', function(data) {
            console.log('✅ Data Pusher masuk:', data);
            fetchNotif();
        });
    </script>
    <!-- Services Section -->
    <section id="services" class="services section light-background">
        <!-- Section Title -->
        <div class="container section-title pt-5" data-aos="fade-up">
            <h2>Layanan Konseling</h2>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal"
                        data-bs-target="#konselingModal">
                        <div class="service-card d-flex p-4 h-100 shadow-sm rounded-3">
                            <div class="icon flex-shrink-0 me-3" style="background:none;">
                                <i class="bi bi-chat-left display-5 text-primary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Mulai Konseling</h5>
                                <p class="mb-0 small">
                                    Silahkan isi form untuk memulai sesi konseling. Pastikan semua data sudah benar.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Modal Mulai Konseling -->
                <div class="modal fade @if ($errors->any()) show d-block @endif" id="konselingModal"
                    tabindex="-1" aria-labelledby="konselingModalLabel" aria-hidden="true" data-bs-backdrop="static"
                    data-bs-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('siswa.konselingStore') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="konselingModalLabel">Mulai Sesi Konseling</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Konseling</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul') }}">
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="isi_konseling" class="form-label">Isi Konseling</label>
                                        <textarea class="form-control @error('isi_konseling') is-invalid @enderror" id="isi_konseling" name="isi_konseling"
                                            rows="4">{{ old('isi_konseling') }}</textarea>
                                        @error('isi_konseling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Kirim Konseling</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        @if ($errors->any())
                            var myModal = new bootstrap.Modal(document.getElementById('konselingModal'), {
                                backdrop: 'static',
                                keyboard: false
                            });
                            myModal.show();
                        @endif
                    });
                </script>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="150">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="service-card d-flex p-4 h-100 shadow-sm rounded-3">
                            <div class="icon flex-shrink-0 me-3" style="background:none;">
                                <i class="bi bi-chat-left-text display-5 text-success"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Jawaban Belum Dibaca</h5>
                                <p class="mb-0 small">
                                    Cek jawaban dari guru BK yang belum Anda baca untuk mendapatkan update.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                @if ($konseling->count() == 0)
                    <!-- Jika tidak ada riwayat -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="service-card d-flex p-4 h-100 shadow-sm rounded-3">
                                <div class="icon flex-shrink-0 me-3" style="background:none;">
                                    <i class="bi bi-emoji-frown display-5 text-secondary"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Belum Ada Riwayat</h5>
                                    <p class="mb-0 small">
                                        Wah, kamu belum pernah konsultasi 😢<br>
                                        Yuk, <strong>mulai konsultasi</strong> pertama kamu dengan guru BK!
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <!-- Jika sudah ada riwayat -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('siswa.konselingRiwayat') }}" class="text-decoration-none text-dark">
                            <div class="service-card d-flex p-4 h-100 shadow-sm rounded-3">
                                <div class="icon flex-shrink-0 me-3" style="background:none;">
                                    <i class="bi bi-chat-left-heart display-5 text-danger"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Riwayat Konseling</h5>
                                    <p class="mb-0 small">
                                        Lihat daftar sesi konseling yang sudah Anda lakukan bersama guru BK.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
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
        <section id="call-to-action" class="call-to-action section" style="background: none">
            <!-- Section Title -->
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row content justify-content-center align-items-center position-relative">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 id="quote-text" class="display-5 text-white" style="font-size: 1.8rem; font-weight: 600">
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
    </section>

    <!-- Tambahkan CSS hover -->
    <style>
        .service-card {
            transition: all 0.3s ease;
            background-color: #fff;
        }

        a:hover .service-card,
        .service-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
            background-color: #f9f9f9;
        }
    </style>
@endsection
