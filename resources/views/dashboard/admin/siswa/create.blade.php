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
                    <p class="text-subtitle text-muted">Silakan masukkan data siswa di bawah ini.</p>

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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="nisn">NISN
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nisn') is-invalid @enderror"
                                                        id="nisn" placeholder="NISN" name="nisn"
                                                        value="{{ old('nisn') }}">
                                                    @error('nisn')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="nama">Nama
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror"
                                                        id="nama" placeholder="Nama" name="nama"
                                                        value="{{ old('nama') }}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="jenis_kelamin">Jenis Kelamin
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
                                                    </label>
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

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="kelas">Kelas
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="agama_id">Agama
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="tahun_masuk">Tahun Masuk
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
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

                                        <hr>

                                        <div class="row">
                                            <h4 class="card-title">Tambah Data Akun Siswa Login</h4>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label mb-0" for="email">Email
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
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
                                                    <label class="form-label mb-0" for="password">Password
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
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
                                                    <label class="form-label mb-0" for="role">Role
                                                        <span class="text-danger"
                                                            style="font-size: 1.2rem; font-weight: bold;">*</span></label>
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
