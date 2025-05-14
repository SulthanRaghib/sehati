@extends('home')
@section('main-content')
    @push('styles')
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
    @endpush

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
    <!-- Services Section -->
    <section id="services" class="services section">
        <!-- Section Title -->
        <div class="pt-3">
            <div class="container section-title pt-5 pb-3" data-aos="fade-up">
                <h2>Layanan Konseling</h2>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">
                <!-- Mulai Konseling -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal"
                        data-bs-target="#konselingModal">
                        <div class="service-card d-flex align-items-center p-4 h-100 shadow-sm rounded-3">
                            <div class="icon flex-shrink-0 me-3 position-relative" style="background:none;">
                                <i class="bi bi-chat-left display-5 text-primary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Mulai Konseling</h5>
                                <p class="mb-0 small">
                                    Silahkan isi form untuk memulai sesi konseling. Pastikan semua data sudah benar.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Jawaban Belum Dibaca -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="150">
                    <a href="{{ route('siswa.konselingJawabanUnread') }}"
                        class="text-decoration-none text-dark position-relative">
                        <div class="service-card d-flex align-items-center p-4 h-100 shadow-sm rounded-3">
                            <div class="icon flex-shrink-0 me-3 position-relative" style="background:none;">
                                <i class="bi bi-chat-left-text display-5 text-success"></i>

                                <!-- Notif badge -->
                                <span id="notif-count"
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.75rem; padding: 0.3rem 0.5rem;">
                                    <!-- Notifikasi akan dimasukkan di sini -->
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Berikan Penilaian Jawaban</h5>
                                <p class="mb-0 small">
                                    Pendapatmu sangat berarti sebagai umpan balik agar layanan konseling bisa menjadi lebih
                                    baik ke depannya.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Riwayat Konseling -->
                @if ($konseling->count() == 0)
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="service-card d-flex align-items-center p-4 h-100 shadow-sm rounded-3">
                                <div class="icon flex-shrink-0 me-3" style="background:none;">
                                    <i class="bi bi-emoji-frown display-5 text-secondary"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Belum Ada Riwayat</h5>
                                    <p class="mb-0 small">
                                        Wah, kamu belum pernah konsultasi 😢<br>
                                        Yuk, <strong>mulai konsultasi</strong> pertama kamu dengan guru BK!
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('siswa.konselingRiwayat') }}" class="text-decoration-none text-dark">
                            <div class="service-card d-flex align-items-center p-4 h-100 shadow-sm rounded-3">
                                <div class="icon flex-shrink-0 me-3" style="background:none;">
                                    <i class="bi bi-chat-left-heart display-5 text-danger"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Riwayat Konseling</h5>
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

        <!-- Modal Mulai Konseling -->
        <div class="modal fade" id="konselingModal" tabindex="-1" aria-labelledby="konselingModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('siswa.konselingStore') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="konselingModalLabel">Cerita Yuk, Ada Apa Hari Ini?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted mb-3">
                                Kamu nggak sendirian kok. Kami ada di sini buat mendengarkan ceritamu dengan sepenuh hati.
                                Sebelum kamu mulai bercerita, coba pilih dulu ya topik yang paling menggambarkan isi hatimu
                                saat ini.
                                Ini bakal bantu kami memahami dan menemani kamu dengan lebih baik. 😊
                            </p>

                            <div class="mb-3">
                                <label for="kategori_konseling" class="form-label fw-semibold">Topik Ceritamu</label>
                                <select class="form-select @error('kategori_konseling') is-invalid @enderror"
                                    name="kategori_konseling" id="kategori_konseling">
                                    <option value="">-- Pilih topik yang paling sesuai --</option>
                                    @foreach ($kategoriKonseling as $kk)
                                        <option value="{{ $kk->id }}"
                                            {{ old('kategori_konseling') == $kk->id ? 'selected' : '' }}>
                                            {{ $kk->nama_kategori }} ({{ strtolower($kk->contoh_kategori) }})
                                    @endforeach
                                </select>
                                @error('kategori_konseling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="judul" class="form-label fw-semibold">Kalimat Singkat Tentang Apa yang Kamu
                                    Rasakan</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul') }}"
                                    placeholder="Contoh: Aku merasa kewalahan dengan semuanya akhir-akhir ini">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="isi_konseling" class="form-label fw-semibold">Ceritakan Lebih Lengkap di Sini,
                                    Kami
                                    Siap
                                    Mendengarkan</label>
                                <textarea class="form-control @error('isi_konseling') is-invalid @enderror" id="isi_konseling" name="isi_konseling"
                                    rows="5" placeholder="Tulis saja semua yang kamu rasakan. Kami siap mendengarkan, tanpa menghakimi...">{{ old('isi_konseling') }}</textarea>
                                @error('isi_konseling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <small class="text-muted">Terima kasih sudah mempercayakan ceritamu. Kamu nggak sendirian,
                                ya.</small>
                            <div>
                                <button type="submit" class="btn btn-primary">Kirim Cerita Saya</button>
                                <button type="button" class="btn btn-secondary" id="btn-batal-konseling">Batal</button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalEl = document.getElementById('konselingModal');
                const modalInstance = new bootstrap.Modal(modalEl);

                // Jika ada error validasi dari server, tampilkan modal otomatis
                @if ($errors->any())
                    modalInstance.show();
                @endif

                // Event tombol batal
                const batalBtn = document.getElementById('btn-batal-konseling');
                if (batalBtn) {
                    batalBtn.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Tampilkan konfirmasi SweetAlert
                        Swal.fire({
                            title: 'Yakin ingin membatalkan?',
                            text: "Ceritamu belum tersimpan. Tapi nggak apa-apa, kamu bisa cerita nanti juga kok. 😊",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, batalkan',
                            cancelButtonText: 'Kembali ke cerita',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Tutup modal
                                modalInstance.hide();

                                // Hapus backdrop sisa jika ada
                                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                                // Reset form dan kosongkan semua input (tanpa reset CSRF token)
                                const form = modalEl.querySelector('form');

                                // Reset semua input selain CSRF token
                                form.querySelectorAll('input, textarea, select').forEach(input => {
                                    if (input.type === 'radio' || input.type === 'checkbox') {
                                        input.checked = false; // Reset radio/checkbox
                                    } else {
                                        input.value =
                                            ''; // Hapus nilai untuk input dan textarea
                                    }
                                });

                                // Hapus validasi error class dan pesan
                                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove(
                                    'is-invalid'));
                                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                                // Pastikan CSRF token tetap ada
                                const csrfToken = form.querySelector('input[name="_token"]');
                                if (csrfToken) {
                                    csrfToken.value =
                                        '{{ csrf_token() }}'; // Reset CSRF token jika hilang
                                }
                            } else {
                                modalInstance.show(); // Balik lagi kalau batalin konfirmasi
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection
