@extends('dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Guru</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.guru') }}">Guru</a>
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
                        <h4 class="card-title">Edit Guru</h4>
                        <a href="{{ route('admin.guru') }}" class="btn btn-outline-warning" id="cancel">Batal</a>
                        <script>
                            document.getElementById('cancel').addEventListener('click', function(e) {
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
                            action="{{ route('admin.guru.update', $guru->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="nip">NIP</label>
                                                <input type="text"
                                                    class="form-control @error('nip') is-invalid @enderror" id="nip"
                                                    placeholder="NIP" name="nip" value="{{ $guru->nip }}">
                                                @error('nip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" id="nama"
                                                    placeholder="Nama" name="nama" value="{{ $guru->nama }}">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tempat_lahir">Tempat Lahir</label>
                                                        <input type="text"
                                                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                            id="tempat_lahir" placeholder="Tempat Lahir" name="tempat_lahir"
                                                            value="{{ $guru->tempat_lahir }}">
                                                        @error('tempat_lahir')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                                        <input type="date"
                                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                            id="tanggal_lahir" placeholder="Tanggal Lahir"
                                                            name="tanggal_lahir" value="{{ $guru->tanggal_lahir }}">
                                                        @error('tanggal_lahir')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                                        <select
                                                            class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                            id="jenis_kelamin" name="jenis_kelamin">
                                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                                            <option value="L"
                                                                {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                Laki-laki</option>
                                                            <option value="P"
                                                                {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="agama_id">Agama</label>
                                                        <select class="form-control @error('agama_id') is-invalid @enderror"
                                                            id="agama_id" name="agama_id">
                                                            <option value="">-- Pilih Agama --</option>
                                                            @foreach ($agama as $a)
                                                                <option value="{{ $a->id }}"
                                                                    {{ $guru->agama_id == $a->id ? 'selected' : '' }}>
                                                                    {{ $a->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="pendidikan_terakhir_id">Pendidikan Terakhir</label>
                                                        <select
                                                            class="form-control @error('pendidikan_terakhir_id') is-invalid @enderror"
                                                            id="pendidikan_terakhir_id" name="pendidikan_terakhir_id">
                                                            <option value="">-- Pilih Pendidikan Terakhir --</option>
                                                            @foreach ($pendidikan_terakhir as $p)
                                                                <option value="{{ $p->id }}"
                                                                    {{ $guru->pendidikan_terakhir_id == $p->id ? 'selected' : '' }}>
                                                                    {{ $p->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Alamat">{{ $guru->alamat }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                                    Update Guru
                                                </button>
                                            </div>
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
