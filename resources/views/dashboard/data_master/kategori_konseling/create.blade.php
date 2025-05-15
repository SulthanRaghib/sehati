@extends('dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Kategori Konseling</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.kategoriKonseling') }}">Kategori Konseling</a>
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
                        <h4 class="card-title">Tambah Kategori Konseling</h4>
                        <a href="{{ route('admin.kategoriKonseling') }}" class="btn btn-outline-warning"
                            id="kembali">Kembali</a>
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
                        <form class="form form-vertical" method="POST"
                            action="{{ route('admin.kategoriKonseling.store') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="nama_kategori">Nama Kategori Konseling</label>
                                            <input type="text" id="nama"
                                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                                name="nama_kategori" placeholder="Contoh : Kesehatan Mental"
                                                value="{{ old('nama_kategori') }}">
                                            @error('nama_kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="contoh_kategori">Contoh Kategori Konseling</label>
                                            <input type="text" id="contoh"
                                                class="form-control @error('contoh_kategori') is-invalid @enderror"
                                                name="contoh_kategori" placeholder="Contoh : Kecemasan, Depresi, dll"
                                                value="{{ old('contoh_kategori') }}">
                                            @error('contoh_kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const contohInput = document.getElementById('contoh');

        contohInput.addEventListener('keydown', function(e) {
            // Simpan apakah karakter yang diketik adalah koma
            contohInput.isCommaKey = (e.key === ',');
        });

        contohInput.addEventListener('input', function(e) {
            const input = e.target;
            const cursor = input.selectionStart;
            const value = input.value;

            // Cek: hanya tambahkan spasi jika user baru mengetik koma (bukan karena edit/backspace)
            if (input.isCommaKey) {
                // Pastikan setelah koma tidak ada spasi
                if (value[cursor - 1] === ',' && value[cursor] !== ' ') {
                    input.value = value.slice(0, cursor) + ' ' + value.slice(cursor);
                    input.setSelectionRange(cursor + 1, cursor + 1);
                }
            }

            input.isCommaKey = false; // reset status setelah input
        });
    </script>
@endpush
