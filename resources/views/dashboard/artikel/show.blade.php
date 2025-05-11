@extends('dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">


                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('artikel') }}">Artikel</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>Detail Artikel</h4>
                                <div>
                                    <a href="{{ route('artikel') }}" class="btn btn-outline-primary">Kembali</a>
                                    <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3 shadow-sm border-0">
                            <div class="card-body">
                                {{-- Judul Artikel --}}
                                <h1 class="text-center mb-4">{{ $artikel->judul }}</h1>

                                {{-- Gambar Artikel --}}
                                <div class="text-center mb-4">
                                    @if ($artikel->gambar)
                                        <img src="{{ Str::startsWith($artikel->gambar, 'http') ? $artikel->gambar : asset('storage/' . $artikel->gambar) }}"
                                            alt="Gambar Artikel" class="img-fluid"
                                            style="max-height: 400px; object-fit: cover;">
                                    @else
                                        <span class="badge bg-danger">Tidak ada gambar</span>
                                    @endif
                                </div>

                                {{-- Metadata Artikel --}}
                                <div class="d-flex flex-wrap justify-content-center gap-3 mb-4 align-items-center">
                                    <span class="badge bg-success">
                                        <i class="bi bi-tag-fill me-1"></i> {!! $artikel->artikelKategori->nama ?? '<span class="badge bg-danger">Tidak ada kategori</span>' !!}
                                    </span>
                                    <span class="badge bg-primary">
                                        <i class="bi bi-person-fill me-1"></i> {!! $artikel->user->name ?? '<span class="badge bg-info">Tidak ada penulis</span>' !!}
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-globe2 me-1"></i> {!! $artikel->sumber ?? '<span class="text-danger">Tidak ada sumber</span>' !!}
                                    </span>
                                    <span class="badge bg-info text-dark">
                                        <i class="bi bi-calendar-event-fill me-1"></i>
                                        {{ \Carbon\Carbon::parse($artikel->tanggal_terbit)->format('d M Y') }}
                                    </span>
                                    <span
                                        class="badge {{ $artikel->status === 'publish' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        <i class="bi bi-eye-fill me-1"></i> {{ ucfirst($artikel->status) }}
                                    </span>
                                    <span class="badge bg-dark">
                                        <i class="bi bi-bar-chart-line-fill me-1"></i> {{ $artikel->views ?? 0 }}
                                        View{{ $artikel->views == 1 ? '' : 's' }}
                                    </span>
                                </div>

                                {{-- Tombol Admin untuk Publish/Unpublish --}}
                                <div class="text-center mb-3">
                                    @if ($artikel->status === 'draft')
                                        <form action="{{ route('artikel.publish', $artikel->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-cloud-upload-fill"></i> Publikasikan
                                            </button>
                                        </form>
                                    @elseif($artikel->status === 'publish')
                                        <form action="{{ route('artikel.draft', $artikel->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary text-dark">
                                                <i class="bi bi-file-earmark-text-fill"></i> Kembalikan ke Draf
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <hr>

                                {{-- Isi Artikel --}}
                                <div class="artikel-isi">
                                    {!! $artikel->isi !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
