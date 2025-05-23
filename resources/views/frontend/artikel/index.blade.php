@extends('home')
@section('main-content')
    <div class="features section">
        <!-- Section Title -->
        <div class="pt-3">
            <div class="container section-title pt-5 pb-3" data-aos="fade-up">
                <h2>Artikel</h2>
            </div>
        </div>



        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="d-flex justify-content-center mb-4">
                <div class="col-12 col-md-6">
                    {{-- Search Bar --}}
                    <form method="GET" action="{{ url()->current() }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari artikel: Judul, Isi, Kategori" value="{{ request('search') }}">
                            <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($artikel as $a)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            @if ($a->gambar)
                                <img src="{{ asset('storage/' . $a->gambar) }}" class="card-img-top"
                                    alt="{{ $a->judul }}">
                            @else
                                <img src="{{ $a->gambar }}" class="card-img-top" alt="{{ $a->judul }}">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $a->judul }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    @php
                                        $tanggal = \Carbon\Carbon::parse($a->tanggal_terbit);
                                        $tanggalTerbit = $tanggal->locale('id_ID')->translatedFormat('l, d F Y');
                                    @endphp
                                    {{ $tanggalTerbit }} | Kategori:
                                    {!! $a->artikelKategori->nama ?? '<span class="badge bg-info">Tidak ada kategori</span>' !!}
                                </p>
                                <p class="card-text">
                                    {!! Str::limit(strip_tags($a->isi), 100) !!}
                                </p>
                                <a href="{{ route('siswa.artikel.show', $a->slug) }}" class="btn btn-primary mt-auto">Baca
                                    Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">Belum ada artikel yang tersedia, anda bisa meminta guru
                            untuk menambahkan artikel. Silahkan hubungi guru BK atau mengajukan permintaan melalui
                            <a href="{{ route('siswa.konseling') }}" class="text-decoration-none">Konseling</a>.
                        </div>
                    </div>
                @endforelse
            </div>
            {{ $artikel->links('vendor.pagination.custom') }}
        </div>
        <!-- End Section Title -->
    </div>
@endsection
