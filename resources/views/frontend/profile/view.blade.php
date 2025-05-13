<!-- Preview Tab -->
<div class="tab-pane fade show active" id="preview" role="tabpanel">
    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center position-relative">
                    <div class="position-relative d-inline-block">
                        @if ($siswa->foto == null)
                            <img src="{{ asset('mine/img/user_default.png') }}" class="rounded-circle img-thumbnail mb-3"
                                width="120" height="120" alt="Foto Profil">
                        @else
                            <img src="{{ asset('storage/img/siswa/' . $siswa->foto) }}"
                                class="rounded-circle img-thumbnail mb-3" width="150" height="150"
                                alt="Foto Profil">
                        @endif

                        <!-- Label sebagai pemicu input file -->
                        <label class="btn btn-sm btn-light position-absolute top-0 end-0 rounded-circle shadow"
                            style="transform: translate(-30%, 10%); cursor: pointer;" data-bs-toggle="tooltip"
                            data-bs-title="Edit Foto">
                            <i class="bi bi-pencil-fill text-primary"></i>
                            <!-- Input file tersembunyi -->
                            <input type="file" name="foto" accept="image/*" id="avatar" class="d-none"
                                style="opacity: 0; width: 0; height: 0; position: absolute;"
                                onchange="this.form.submit()" />
                        </label>
                        <img src="{{ $siswa->foto }}" alt="" class="img-fluid rounded-circle" id="preview"
                            style="display: none; width: 120px; height: 120px;">
                    </div>

                    <h5 class="mb-1"> {!! $siswa->nama ?? '<span class="badge bg-danger">Nama belum diisi</span>' !!}</h5>
                    <p class="text-muted mb-1">{!! $siswa->nisn ?? '<span class="badge bg-danger">NISN belum tersedia</span>' !!}</p>
                    <p class="text-muted mb-2">{!! $siswa->user->email ?? '<span class="badge bg-danger">Email belum diisi</span>' !!}</p>
                    <p class="text-muted"><small>{!! $siswa->alamat ?? '<span class="badge bg-danger">Alamat belum diisi</span>' !!}</small></p>

                    {{-- <h6 class="mt-4 text-primary fw-bold">Social Links</h6>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-instagram"></i></a>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header border-bottom d-flex justify-content-between">
                    <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details"
                                role="tab">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ayah-tab" data-bs-toggle="tab" href="#ayah" role="tab">Data
                                Ayah</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ibu-tab" data-bs-toggle="tab" href="#ibu" role="tab">Data
                                Ibu</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">
                    <!-- Personal Details -->
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="30%">Nama</th>
                                <td>: {!! $siswa->nama ?? '<span class="badge bg-danger">Nama belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>: {!! $siswa->nisn ?? '<span class="badge bg-danger">NISN belum tersedia</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>: {!! $siswa->tempat_lahir ?? '<span class="badge bg-danger">Tempat Lahir belum diisi</span>' !!}, {!! $siswa->tanggal_lahir ?? '<span class="badge bg-danger">Tanggal Lahir belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>: {!! $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' !!}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>: {!! $siswa->no_hp ?? '<span class="badge bg-danger">No HP belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: {!! $siswa->kelas->tingkat ?? '<span class="badge bg-danger">Kelas belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>: {!! $siswa->agama->nama ?? '<span class="badge bg-danger">Agama belum diisi</span>' !!}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Data Ayah -->
                    <div class="tab-pane fade" id="ayah" role="tabpanel">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>NIK Ayah</th>
                                <td>: {!! $siswa->nik_ayah ?? '<span class="badge bg-danger">NIK Ayah belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Nama Ayah</th>
                                <td>: {!! $siswa->nama_ayah ?? '<span class="badge bg-danger">Nama Ayah belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tgl Lahir</th>
                                <td>: {!! $siswa->tempat_lahir_ayah ?? '<span class="badge bg-danger">Tempat Lahir belum diisi</span>' !!}, {!! $siswa->tanggal_lahir_ayah ?? '<span class="badge bg-danger">Tanggal Lahir belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>: {!! $siswa->pekerjaanAyah->nama ?? '<span class="badge bg-danger">Pekerjaan belum diisi</span>' !!}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Data Ibu -->
                    <div class="tab-pane fade" id="ibu" role="tabpanel">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>NIK Ibu</th>
                                <td>: {!! $siswa->nik_ibu ?? '<span class="badge bg-danger">NIK Ibu belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Nama Ibu</th>
                                <td>: {!! $siswa->nama_ibu ?? '<span class="badge bg-danger">Nama Ibu belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tgl Lahir</th>
                                <td>: {!! $siswa->tempat_lahir_ibu ?? '<span class="badge bg-danger">Tempat Lahir belum diisi</span>' !!}, {!! $siswa->tanggal_lahir_ibu ?? '<span class="badge bg-danger">Tanggal Lahir belum diisi</span>' !!}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>: {!! $siswa->pekerjaanIbu->nama ?? '<span class="badge bg-danger">Pekerjaan belum diisi</span>' !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            processURL: '{{ route('siswa.upload.foto') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: '{{ $siswa->id }}',
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
