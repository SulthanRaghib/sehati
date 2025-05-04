@extends('home')
@section('main-content')
    <!-- Services Section -->
    <section id="services" class="services section">
        <!-- Section Title -->
        <div class="pt-3">
            <div class="container section-title pt-5 pb-3" data-aos="fade-up">
                <h2>Riwayat Konseling</h2>
            </div>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Isi Konseling</th>
                            <th>Status</th>
                            <th>Tanggal Konseling</th>
                            <th>Balasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($konseling as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->judul }}</td>
                                <td>{{ Str::limit($k->isi_konseling, 100) }}</td>
                                <td>
                                    @switch($k->status_id)
                                        @case(1)
                                            <span class="badge bg-warning">Menunggu</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-info">Dijawab</span>
                                        @break

                                        @case(3)
                                            <span class="badge bg-success">Selesai</span>
                                        @break

                                        @default
                                            <span class="badge bg-dark">Tidak Diketahui</span>
                                    @endswitch
                                </td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_konseling)->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($k->status_id == 2)
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#balasanModal{{ $k->id }}">
                                            Lihat
                                        </button>

                                        <!-- Modal Balasan -->
                                        <div class="modal fade" id="balasanModal{{ $k->id }}" tabindex="-1"
                                            aria-labelledby="balasanLabel{{ $k->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="balasanLabel{{ $k->id }}">Balasan
                                                            Konseling</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="word-break: break-word; overflow-wrap: break-word;">
                                                        {{ $k->jawaban->isi_jawaban }}

                                                        <hr>
                                                        <!-- Peringatan Rating -->
                                                        <div class="alert alert-warning mt-3">
                                                            Silakan berikan rating atas balasan ini.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($k->status_id == 3)
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#balasanModal{{ $k->id }}">
                                            Lihat
                                        </button>

                                        <!-- Modal Balasan dengan Rating -->
                                        <div class="modal fade" id="balasanModal{{ $k->id }}" tabindex="-1"
                                            aria-labelledby="balasanLabel{{ $k->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="balasanLabel{{ $k->id }}">
                                                            Balasan Konseling</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="word-break: break-word; overflow-wrap: break-word;">
                                                        <p>{{ $k->jawaban->isi_jawaban }}</p>

                                                        <hr>

                                                        <!-- Tampilkan Rating -->
                                                        @php
                                                            $rating = $k->jawaban->ratings ?? null;
                                                        @endphp

                                                        @if ($rating)
                                                            <div class="mt-4">
                                                                <h6>Rating Anda:</h6>
                                                                <p>
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $rating->rating)
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                        @else
                                                                            <i class="bi bi-star text-secondary"></i>
                                                                        @endif
                                                                    @endfor
                                                                    <br>
                                                                    <small>Komentar:
                                                                        {{ $rating->komentar ?? 'Tidak ada komentar.' }}</small>
                                                                </p>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning mt-3" role="alert">
                                                                Silakan berikan rating jika Anda merasa jawaban ini
                                                                membantu.
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Belum Ada Jawaban</span>
                                    @endif
                                    {{-- delete --}}
                                    <form action="{{ route('siswa.konseling.destroy', $k->id) }}" method="POST"
                                        class="d-inline form-delete">
                                        @csrf
                                        @method('delete')
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger btn-delete">Delete</button>

                                        <script>
                                            // Seleksi semua tombol hapus
                                            document.querySelectorAll('.btn-delete').forEach(button => {
                                                button.addEventListener('click', function(e) {
                                                    e.preventDefault(); // Mencegah form langsung terkirim

                                                    // Ambil form terdekat dari tombol
                                                    const form = this.closest('.form-delete');

                                                    // Tampilkan SweetAlert
                                                    Swal.fire({
                                                        title: 'Apakah Anda yakin?',
                                                        text: "Data Konseling ini akan dihapus secara permanen!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#d33',
                                                        cancelButtonColor: '#3085d6',
                                                        confirmButtonText: 'Ya, Hapus!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Submit form jika dikonfirmasi
                                                            form.submit();
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
