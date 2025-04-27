@extends('home')
@section('main-content')
    <!-- Services Section -->
    <section id="services" class="services section light-background">
        <!-- Section Title -->
        <div class="container section-title pt-5" data-aos="fade-up">
            <h2>Riwayat Konseling</h2>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
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
                                            <span class="badge bg-success">Direspon</span>
                                        @break

                                        @case(3)
                                            <span class="badge bg-secondary">Selesai</span>
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
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="balasanLabel{{ $k->id }}">Balasan
                                                            Konseling</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! nl2br(e($k->jawaban->isi_jawaban)) !!}
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
