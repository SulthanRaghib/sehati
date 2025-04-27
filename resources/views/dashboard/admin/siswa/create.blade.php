@extends('dashboard')
@section('content')
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            })
        </script>
    @endif

    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Siswa</h3>

                    @if (session('show_tahun_akademik_form'))
                        <div class="alert alert-warning">
                            <strong>Perhatian!</strong> Tahun akademik aktif belum ada.
                            <form class="form form-vertical" method="POST" action="{{ route('tahun-akademik.store') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="periode">Periode</label>
                                                <input type="text"
                                                    class="form-control @error('periode') is-invalid @enderror"
                                                    id="periode" placeholder="Contoh: 2023/2024" name="periode"
                                                    value="{{ old('periode') }}">
                                                @error('periode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="semester">Semester</label>
                                                <select name="semester"
                                                    class="form-control @error('semester') is-invalid @enderror"
                                                    id="semester">
                                                    <option value="" disabled selected>Pilih Semester</option>
                                                    <option value="Ganjil"
                                                        {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>
                                                        Ganjil</option>
                                                    <option value="Genap"
                                                        {{ old('semester') == 'Genap' ? 'selected' : '' }}>
                                                        Genap</option>
                                                </select>
                                                @error('semester')
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
                            </form>
                        </div>
                    @endif

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.siswa') }}">Siswa</a>
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
                        <h4 class="card-title">Tambah Siswa</h4>
                        <a href="{{ route('admin.siswa') }}" class="btn btn-outline-warning" id="kembali">Kembali</a>
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
                        <form class="form form-vertical" method="POST" action="{{ route('admin.siswa.store') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nisn">NISN</label>
                                                    <input type="text"
                                                        class="form-control @error('nisn') is-invalid @enderror"
                                                        id="nisn" placeholder="NISN" name="nisn"
                                                        value="{{ old('nisn') }}">
                                                    @error('nisn')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror"
                                                        id="nama" placeholder="Nama" name="nama"
                                                        value="{{ old('nama') }}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <select
                                                        class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                        id="jenis_kelamin" name="jenis_kelamin">
                                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                                        <option value="L"
                                                            {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                                            Laki-laki</option>
                                                        <option value="P"
                                                            {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                                            Perempuan</option>
                                                    </select>
                                                    @error('jenis_kelamin')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="kelas">Kelas</label>
                                                    <select class="form-control @error('kelas_id') is-invalid @enderror"
                                                        id="kelas" name="kelas_id">
                                                        <option value="">-- Pilih Kelas --</option>
                                                        @foreach ($kelas as $k)
                                                            @php
                                                                $namaTingkat = $k->tingkat;
                                                                if ($namaTingkat == 'X') {
                                                                    $kelas = 'Sepuluh';
                                                                } elseif ($namaTingkat == 'XI') {
                                                                    $kelas = 'Sebelas';
                                                                } else {
                                                                    $kelas = 'Dua Belas';
                                                                }
                                                            @endphp
                                                            <option value="{{ $k->id }}"
                                                                {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                                                {{ $k->tingkat }} ({{ $kelas }})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('kelas_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text"
                                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                        id="tempat_lahir" placeholder="Tempat Lahir" name="tempat_lahir"
                                                        value="{{ old('tempat_lahir') }}">
                                                    @error('tempat_lahir')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="date"
                                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                        id="tanggal_lahir" name="tanggal_lahir"
                                                        value="{{ old('tanggal_lahir') }}">
                                                    @error('tanggal_lahir')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="agama_id">Agama</label>
                                                    <select class="form-control @error('agama_id') is-invalid @enderror"
                                                        id="agama_id" name="agama_id">
                                                        <option value="">-- Pilih Agama --</option>
                                                        @foreach ($agama as $a)
                                                            <option value="{{ $a->id }}"
                                                                {{ old('agama_id') == $a->id ? 'selected' : '' }}>
                                                                {{ $a->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('agama_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tahun_masuk">Tahun Masuk</label>
                                                    <input type="text"
                                                        class="form-control @error('tahun_masuk') is-invalid @enderror"
                                                        id="tahun_masuk" placeholder="Tahun Masuk Sekolah"
                                                        name="tahun_masuk" value="{{ old('tahun_masuk') }}">
                                                    @error('tahun_masuk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat Siswa</label>
                                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                                                    @error('alamat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Data Ayah</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nik_ayah">NIK</label>
                                                            <input type="text"
                                                                class="form-control @error('nik_ayah') is-invalid @enderror"
                                                                id="nik_ayah" name="nik_ayah"
                                                                value="{{ old('nik_ayah') }}">
                                                            @error('nik_ayah')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama_ayah">Nama</label>
                                                            <input type="text"
                                                                class="form-control @error('nama_ayah') is-invalid @enderror"
                                                                id="nama_ayah" name="nama_ayah"
                                                                value="{{ old('nama_ayah') }}">
                                                            @error('nama_ayah')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tempat_lahir_ayah">Tempat Lahir</label>
                                                            <input type="text"
                                                                class="form-control @error('tempat_lahir_ayah') is-invalid @enderror"
                                                                id="tempat_lahir_ayah" name="tempat_lahir_ayah"
                                                                value="{{ old('tempat_lahir_ayah') }}">
                                                            @error('tempat_lahir_ayah')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tanggal_lahir_ayah">Tanggal Lahir</label>
                                                            <input type="date"
                                                                class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror"
                                                                id="tanggal_lahir_ayah" name="tanggal_lahir_ayah"
                                                                value="{{ old('tanggal_lahir_ayah') }}">
                                                            @error('tanggal_lahir_ayah')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pekerjaan_ayah">Pekerjaan</label>
                                                    <select
                                                        class="form-control @error('pekerjaan_ayah_id') is-invalid @enderror"
                                                        id="pekerjaan_ayah_id" name="pekerjaan_ayah_id">
                                                        <option value="">-- Pilih Pekerjaan --</option>
                                                        @foreach ($pekerjaan as $p)
                                                            <option value="{{ $p->id }}"
                                                                {{ old('pekerjaan_ayah_id') == $p->id ? 'selected' : '' }}>
                                                                {{ $p->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('pekerjaan_ayah')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Data Ibu</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nik_ibu">NIK</label>
                                                            <input type="text"
                                                                class="form-control @error('nik_ibu') is-invalid @enderror"
                                                                id="nik_ibu" name="nik_ibu"
                                                                value="{{ old('nik_ibu') }}">
                                                            @error('nik_ibu')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama_ibu">Nama</label>
                                                            <input type="text"
                                                                class="form-control @error('nama_ibu') is-invalid @enderror"
                                                                id="nama_ibu" name="nama_ibu"
                                                                value="{{ old('nama_ibu') }}">
                                                            @error('nama_ibu')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tempat_lahir_ibu">Tempat Lahir</label>
                                                            <input type="text"
                                                                class="form-control @error('tempat_lahir_ibu') is-invalid @enderror"
                                                                id="tempat_lahir_ibu" name="tempat_lahir_ibu"
                                                                value="{{ old('tempat_lahir_ibu') }}">
                                                            @error('tempat_lahir_ibu')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tanggal_lahir_ibu">Tanggal Lahir</label>
                                                            <input type="date"
                                                                class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror"
                                                                id="tanggal_lahir_ibu" name="tanggal_lahir_ibu"
                                                                value="{{ old('tanggal_lahir_ibu') }}">
                                                            @error('tanggal_lahir_ibu')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pekerjaan_ibu">Pekerjaan</label>
                                                    <select
                                                        class="form-control @error('pekerjaan_ibu_id') is-invalid @enderror"
                                                        id="pekerjaan_ibu_id" name="pekerjaan_ibu_id">
                                                        <option value="">-- Pilih Pekerjaan --</option>
                                                        @foreach ($pekerjaan as $p)
                                                            <option value="{{ $p->id }}"
                                                                {{ old('pekerjaan_ibu_id') == $p->id ? 'selected' : '' }}>
                                                                {{ $p->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('pekerjaan_ibu')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <h4 class="card-title">Tambah Data Akun Siswa Login</h4>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" placeholder="Email" name="email"
                                                        value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <div class="input-group">
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            id="password" placeholder="Password" name="password">
                                                        <span class="input-group-text" id="basic-addon">
                                                            <button type="button" id="togglePassword"
                                                                class="btn btn-icon-sm p-0">
                                                                <i data-feather="eye-off"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    @error('password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <select class="form-control @error('role') is-invalid @enderror"
                                                        id="role" name="role" disabled>
                                                        <option value="">-- Pilih Role --</option>
                                                        <option value="siswa"
                                                            {{ old('role') == 'siswa' ? 'selected' : 'selected' }}>
                                                            Siswa</option>
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
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
@endsection
