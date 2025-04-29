@extends('home')
@section('main-content')
    <div class="features section">
        <!-- Section Title -->
        <div class="container section-title pt-5 mt-4 pb-3" data-aos="fade-up">
            <div class="col-lg-12 col-md-12">

                <div class="mb-4">
                    <a href="{{ route('siswa.artikel') }}" class="btn btn-outline-secondary">
                        ← Kembali ke Daftar Artikel
                    </a>
                </div>

                <div class="card shadow-sm border-0">
                    @if ($artikel->gambar)
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}"
                            class="card-img-top rounded-top" style="object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <h1 class="card-title">{{ $artikel->judul }}</h1>
                        {{-- Meta Info --}}
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                            <div>
                                @php
                                    $tanggal = \Carbon\Carbon::parse($artikel->tanggal_terbit);
                                    $tanggalTerbit = $tanggal->locale('id_ID')->translatedFormat('l, d F Y');
                                @endphp
                                <span>Dipublikasikan: {{ $tanggalTerbit }}</span>
                                <span class="mx-2">|</span>
                                <span>Ditulis oleh <strong>{{ $artikel->user->name ?? '-' }}</strong></span>
                                <span class="mx-2">|</span>
                                <span>Kategori: <span
                                        class="badge bg-primary">{{ $artikel->artikelKategori->nama ?? '-' }}</span>
                            </div>
                            <div>
                                👁️ <span>{{ $artikel->views }} kali dibaca</span>
                            </div>
                        </div>
                        {{-- <p class="text-muted mb-2">

                            Ditulis oleh <strong>{{ $artikel->user->name ?? 'Admin' }}</strong> |
                            {{ $tanggalTerbit }} |
                            Kategori: <span class="badge bg-primary">{{ $artikel->artikelKategori->nama ?? '-' }}</span>
                        </p> --}}

                        <hr>

                        <div class="text-start" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! $artikel->isi !!}
                        </div>

                        @if ($artikel->sumber)
                            <p class="mt-4 small text-muted">
                                Sumber: <a href="{{ $artikel->sumber }}" target="_blank">{{ $artikel->sumber }}</a>
                            </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
