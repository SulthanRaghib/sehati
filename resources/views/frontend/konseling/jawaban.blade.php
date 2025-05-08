@extends('home')
@section('main-content')
    {{-- style --}}
    <style>
        .star-rating .bi-star-fill {
            color: #ffc107;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rating star logic
            const allRatings = document.querySelectorAll('.star-rating');

            allRatings.forEach(starContainer => {
                const stars = starContainer.querySelectorAll('i');
                const ratingInput = starContainer.closest('form').querySelector('.rating-value');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = this.getAttribute('data-rating');
                        ratingInput.value = rating;

                        stars.forEach(s => {
                            if (s.getAttribute('data-rating') <= rating) {
                                s.classList.remove('bi-star');
                                s.classList.add('bi-star-fill', 'text-warning');
                            } else {
                                s.classList.remove('bi-star-fill', 'text-warning');
                                s.classList.add('bi-star');
                            }
                        });
                    });
                });
            });
        });
    </script>
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


    <!-- Jawaban Konseling Section -->
    <section id="services" class="services section light-background">
        <!-- Section Title -->
        <div class="pt-3">
            <div class="container section-title pt-5 pb-3" data-aos="fade-up">
                <h2>{{ $title }}</h2>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container">
            @if ($notifikasi->isEmpty())
                <div class="alert alert-info" role="alert">
                    Semua jawaban konseling sudah Anda nilai. Terima kasih atas partisipasinya!
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="dataTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Topik yang Disampaikan</th>
                                <th>Balasan dari Guru BK</th>
                                <th>Tanggal Jawaban</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifikasi as $n)
                                @php
                                    $jawaban = $n->related;
                                    $konseling = $jawaban->konseling ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $konseling ? Str::limit($konseling->judul, 50) : '-' }}</td>
                                    <td>{!! Str::limit($jawaban->isi_jawaban ?? '-', 90) !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($jawaban->tanggal_jawaban)->format('d M Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#jawabanModal{{ $n->id }}">
                                            Lihat Detail
                                        </button>

                                        <!-- Modal Jawaban -->
                                        <div class="modal fade" id="jawabanModal{{ $n->id }}" tabindex="-1"
                                            aria-labelledby="jawabanLabel{{ $n->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="jawabanLabel{{ $n->id }}">
                                                            Detail Jawaban Konseling
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="word-break: break-word; overflow-wrap: break-word;">
                                                        <strong>Topik yang Disampaikan:</strong>
                                                        <p>{{ $konseling->judul ?? '-' }}</p>
                                                        <strong>Cerita Lengkap:</strong>
                                                        <p>{{ $konseling->isi_konseling ?? '-' }}</p>

                                                        <hr>

                                                        <strong>Balasan dari Guru BK:</strong>
                                                        <p>{!! $jawaban->isi_jawaban ?? '-' !!}</p>

                                                        <hr>

                                                        <!-- Rating Section -->
                                                        <h6 class="mb-0 mt-4">Silakan berikan rating jika Anda merasa
                                                            jawaban ini membantu:</h6>
                                                        <form method="POST" action="{{ route('jawaban.rating') }}"
                                                            class="w-100">
                                                            @csrf
                                                            <input type="hidden" name="jawaban_id"
                                                                value="{{ $n->related->id }}">
                                                            <input type="hidden" name="rating" class="rating-value"
                                                                value="0">

                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="star-rating" style="font-size: 1.8rem;">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="bi bi-star fs-5"
                                                                            data-rating="{{ $i }}"
                                                                            style="cursor: pointer;"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>

                                                            <!-- Komentar -->
                                                            <div class="mb-3">
                                                                <label for="komentar{{ $n->id }}"
                                                                    class="form-label">Komentar (opsional)</label>
                                                                <textarea name="komentar" id="komentar{{ $n->id }}" class="form-control" rows="3"
                                                                    placeholder="Tulis komentar Anda..."></textarea>
                                                            </div>

                                                            <div class="modal-footer px-0">
                                                                <button type="submit" class="btn btn-primary">Kirim
                                                                    Penilaian</button>

                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const modals = document.querySelectorAll('.modal');

            modals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const stars = modal.querySelectorAll('.star-rating i');
                    const ratingValue = modal.querySelector('.rating-value');

                    stars.forEach(star => {
                        star.addEventListener('click', function() {
                            const rating = this.getAttribute('data-rating');
                            ratingValue.value = rating;

                            stars.forEach(s => {
                                if (s.getAttribute('data-rating') <=
                                    rating) {
                                    s.classList.remove('bi-star');
                                    s.classList.add('bi-star-fill');
                                } else {
                                    s.classList.remove('bi-star-fill');
                                    s.classList.add('bi-star');
                                }
                            });
                        });
                    });
                });
            });

            const submitButtons = document.querySelectorAll('.submit-rating');
            submitButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const jawabanId = this.getAttribute('data-jawaban-id');
                    const modal = this.closest('.modal');
                    const rating = modal.querySelector('.rating-value').value;
                    const komentar = modal.querySelector('textarea').value;

                    if (rating == 0) {
                        alert('Silakan beri rating terlebih dahulu.');
                        return;
                    }

                    fetch('/jawaban/rating', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                jawaban_id: jawabanId,
                                rating: rating,
                                komentar: komentar
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(err => {
                                    throw new Error(err.message || 'Gagal menyimpan');
                                });
                            }
                            return res.json();
                        })
                        .then(data => {
                            alert(data.message);
                            modal.querySelector('.btn-close').click();
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan saat mengirim penilaian: ' + err.message);
                        });
                });
            });
        });
    </script> --}}



@endsection
