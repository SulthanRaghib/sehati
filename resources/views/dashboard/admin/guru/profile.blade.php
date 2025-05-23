@extends('dashboard')
@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            })
        </script>
    @endif

    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profile</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="tab-pane fade show active" id="preview" role="tabpanel">
                <div class="row">
                    <!-- Profile Sidebar -->
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center position-relative">
                                <div class="position-relative d-inline-block">
                                    @if ($guru->foto == null)
                                        <img src="{{ asset('mine/img/user_default.png') }}"
                                            class="rounded-circle img-thumbnail mb-3" width="120" height="120"
                                            alt="Foto Profil">
                                    @else
                                        <img src="{{ asset('storage/img/guru/' . $guru->foto) }}"
                                            class="rounded-circle img-thumbnail mb-3" width="150" height="150"
                                            alt="Foto Profil">
                                    @endif

                                    <label class="btn btn-sm position-absolute top-0 end-0 rounded-circle shadow"
                                        style="transform: translate(-100%, 10%); cursor: pointer; background:white;"
                                        data-bs-toggle="tooltip" data-bs-title="Edit Foto">
                                        <i class="bi bi-pencil-fill text-primary"></i>
                                        <input type="file" name="foto" accept="image/*" id="avatar" class="d-none"
                                            onchange="this.form.submit()" />
                                    </label>
                                    <img src="{{ $guru->foto }}" alt="" class="img-fluid rounded-circle"
                                        id="preview" style="display: none; width: 120px; height: 120px;">
                                </div>

                                <h5 class="mb-1">{!! $guru->nama ?? '<span class="text-danger">Nama belum diisi</span>' !!}</h5>
                                <p class="text-muted mb-1">{!! $guru->nip ?? '<span class="text-danger">NIP belum diisi</span>' !!}</p>
                                <span class="badge bg-primary">
                                    <p class="text-white mb-0" style="font-size: 0.8rem">{!! $guru->user->email ?? '<span class="text-danger">Email belum diisi</span>' !!}</p>
                                </span>
                                <p class="text-muted"><small>{!! $guru->alamat ?? '<span class="text-danger">Alamat belum diisi</span>' !!}</small></p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header border-bottom d-flex justify-content-between mb-3">
                                <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details"
                                            role="tab">Biodata Guru</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-tab" data-bs-toggle="tab" href="#edit"
                                            role="tab">Edit Profil</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body tab-content">
                                <!-- Edit Profile -->
                                <div class="tab-pane fade" id="edit" role="tabpanel">
                                    <form action="{{ route('guru.profile.update', $guru->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" name="nama" id="nama" class="form-control"
                                                        value="{{ old('nama', $guru->nama) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="nip">NIP</label>
                                                    <input type="text" name="nip" id="nip" class="form-control"
                                                        value="{{ old('nip', $guru->nip) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                                        class="form-control"
                                                        value="{{ old('tempat_lahir', $guru->tempat_lahir) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                                        class="form-control"
                                                        value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                        <option value="L"
                                                            {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                                                        </option>
                                                        <option value="P"
                                                            {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="agama_id">Agama</label>
                                                    <select name="agama_id" id="agama_id" class="form-control">
                                                        @foreach ($list_agama as $agama)
                                                            <option value="{{ $agama->id }}"
                                                                {{ $guru->agama_id == $agama->id ? 'selected' : '' }}>
                                                                {{ $agama->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label for="pendidikan_terakhir_id">Pendidikan Terakhir</label>
                                                    <select name="pendidikan_terakhir_id" id="pendidikan_terakhir_id"
                                                        class="form-control">
                                                        @foreach ($list_pendidikan as $pendidikan)
                                                            <option value="{{ $pendidikan->id }}"
                                                                {{ $guru->pendidikan_terakhir_id == $pendidikan->id ? 'selected' : '' }}>
                                                                {{ $pendidikan->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $guru->alamat) }}</textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary float-right">Simpan
                                            Perubahan</button>
                                    </form>
                                </div>

                                <!-- Personal Details -->
                                <div class="tab-pane fade show active" id="details" role="tabpanel">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th width="30%">Nama</th>
                                            <td>: {!! $guru->nama ?? '<span class="text-danger">Nama belum diisi</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>NIP</th>
                                            <td>: {!! $guru->nip ?? '<span class="text-danger">NIP belum diisi</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <td>: {!! $guru->tempat_lahir ?? '<span class="text-danger">Tempat Lahir belum diisi</span>' !!}, {!! $guru->tanggal_lahir ?? '<span class="text-danger">Tanggal Lahir belum diisi</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>: {!! $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Agama</th>
                                            <td>: {!! $guru->agama->nama ?? '<span class="text-danger">Agama belum diisi</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Pendidikan Terakhir</th>
                                            <td>: {!! $guru->pendidikanTerakhir->nama ?? '<span class="text-danger">Belum diisi</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: {!! $guru->alamat ?? '<span class="text-danger">Alamat belum diisi</span>' !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // Validasi ukuran sebelum upload
        $('#avatar').on('change', function() {
            const file = this.files[0];
            if (file && file.size > 2097152) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Gambar Terlalu Besar',
                    text: `Anda memilih gambar sebesar ${sizeMB} MB, melebihi batas maksimum 2 MB. Silakan pilih gambar lain.`,
                });
                $(this).val('');
            }
        });

        // Konfigurasi kropify
        $('input[type="file"][id="avatar"]').kropify({
            preview: '#preview',
            viewMode: 1,
            aspectRatio: 1,
            cancelButtonText: 'Cancel',
            resetButtonText: 'Reset',
            cropButtonText: 'Crop & update',
            maxSize: 2097152,
            showLoader: true,
            animationClass: 'headShake',
            fileName: 'foto',
            processURL: '{{ route('guru.upload.foto') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: '{{ $guru->id }}',
            },
            success: function(data) {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Foto berhasil diunggah',
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Foto gagal diunggah',
                    });
                }
            },
            errors: function(error, text) {
                try {
                    const parsed = JSON.parse(text);
                    if (parsed.status === 'error' && parsed.size) {
                        const sizeMB = (parsed.size / (1024 * 1024)).toFixed(2);
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran Gambar Terlalu Besar',
                            text: `Gambar hasil crop sebesar ${sizeMB} MB, melebihi batas maksimum.`,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Upload',
                            text: parsed.message || 'Terjadi kesalahan saat mengunggah gambar.',
                        });
                    }
                } catch (e) {
                    console.error('Parsing error JSON:', text);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat membaca respon server.',
                    });
                }
            }
        });
    </script>
@endpush
