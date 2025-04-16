@extends('dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Artikel</h3>

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
        <div class="col-12">
            <div class="card">
                <div class="card-header  pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tambah Artikel</h4>
                        <a href="{{ route('artikel') }}" class="btn btn-outline-warning" id="kembali">Kembali</a>
                        <script>
                            document.getElementById('kembali').addEventListener('click', function(e) {
                                e.preventDefault();
                                Swal.fire({
                                    title: 'Apakah Anda Yakin ? ',
                                    text: "Anda akan kehilangan data yang sudah diinput!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#FDAC41',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Lanjutkan!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = this.href;
                                    }
                                })
                            });
                        </script>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" method="POST" action="{{ route('artikel.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="judul">Judul Artikel</label>
                                            <input type="text" id="judul"
                                                class="form-control @error('judul') is-invalid @enderror" name="judul"
                                                placeholder="Tulis Judul Artikel" value="{{ old('judul') }}">
                                            @error('judul')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" id="slug"
                                                class="form-control @error('slug') is-invalid @enderror" name="slug"
                                                value="{{ old('slug') }}" readonly>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="isi">Isi Artikel</label>
                                            <textarea id="wordArtikel" class="form-control @error('isi') is-invalid @enderror" name="isi"
                                                placeholder="Tulis Isi Artikel">{{ old('isi') }}</textarea>
                                            @error('isi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="gambar">Gambar Artikel</label>
                                                    <input type="file" id="gambar"
                                                        class="form-control @error('gambar') is-invalid @enderror"
                                                        name="gambar">
                                                    @error('gambar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="kategori">Kategori Artikel</label>
                                                    <select id="kategori"
                                                        class="form-control @error('kategori') is-invalid @enderror"
                                                        name="artikel_kategori_id">
                                                        <option value="" disabled selected>Pilih Kategori
                                                            Artikel</option>
                                                        @foreach ($kategori as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama }}
                                                            </option>
                                                        @endforeach
                                                        <option value="add"
                                                            {{ old('artikel_kategori_id') == 'add' ? 'selected' : '' }}>
                                                            Tambah Kategori</option>

                                                    </select>

                                                </div>
                                                {{-- Input Tambah Kategori Baru --}}
                                                <div id="kategori-baru-group" class="form-group mt-2 d-none">
                                                    <label for="kategori_baru">Kategori Baru</label>
                                                    <input type="text" id="kategori_baru" name="kategori_baru"
                                                        class="form-control @error('kategori_baru') is-invalid @enderror"
                                                        placeholder="Tulis Kategori Baru"
                                                        value="{{ old('kategori_baru') }}">
                                                </div>
                                                @error('artikel_kategori_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="user_id">Penulis</label>
                                                    <input type="text" class="form-control" value="{{ $user->name }}"
                                                        disabled>
                                                    @error('user_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="sumber">Sumber Artikel (opsional)</label>
                                                    <input type="text" id="sumber"
                                                        class="form-control @error('sumber') is-invalid @enderror"
                                                        name="sumber"
                                                        placeholder="Tulis Sumber Artikel atau Link (opsional)"
                                                        value="{{ old('sumber') }}">
                                                    @error('sumber')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select id="status"
                                                        class="form-control @error('status') is-invalid @enderror"
                                                        name="status">
                                                        <option value="" disabled selected>Pilih Status
                                                            Artikel</option>
                                                        <option value="draft"
                                                            {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="publish"
                                                            {{ old('status') == 'publish' ? 'selected' : '' }}>Publish
                                                        </option>
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const judulInput = document.getElementById('judul');
            const slugInput = document.getElementById('slug');

            judulInput.addEventListener('input', function() {
                if (!slugInput.dataset.manual) {
                    const slug = judulInput.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');

                    slugInput.value = slug;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategori');
            const kategoriBaruGroup = document.getElementById('kategori-baru-group');

            function toggleKategoriBaru() {
                const currentVal = kategoriSelect.value;
                if (currentVal === 'add') {
                    kategoriBaruGroup.classList.remove('d-none');
                } else {
                    kategoriBaruGroup.classList.add('d-none');
                }
            }

            // Saat halaman selesai dimuat, pastikan nilai awal terbaca
            toggleKategoriBaru();

            // Tambahkan event listener
            kategoriSelect.addEventListener('change', toggleKategoriBaru);

        });
    </script>
@endsection
